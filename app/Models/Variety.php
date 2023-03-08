<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Size;
use App\Models\Unit;
use App\Models\PackagingSize;
use App\Models\PackagingMaterial;
use App\Models\AdminOfferedProduct;

class Variety extends Model
{
    protected $table    = 'varieties';
    protected $fillable = ['name'];
    protected $hidden   = ['pivot', 'created_at', 'updated_at'];

    public function products()
    {
        return $this->belongsToMany(AdminOfferedProduct::class, 'admin_products_variety');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'variety_size');
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'variety_unit');
    }

    public function packaging_sizes()
    {
        return $this->belongsToMany(PackagingSize::class, 'variety_packaging_size');
    }

    public function packaging_materials()
    {
        return $this->belongsToMany(PackagingMaterial::class, 'variety_packaging_material');
    }

    public static function getVarietiesByFiltering(array $filters, $pagination = false, $limit = false) 
    {
        $query = self::with(['sizes', 'units', 'packaging_sizes', 'packaging_materials']);

        if (!empty($filters['id'])) {
            $query = $query->where('id', $filters['id']);
        }

        if (!empty($filters['name'])) {
            $query = $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        $query = $query->orderBy('id', 'desc');

        if ($pagination) {
            if ($limit) {
                $query = $query->paginate($limit)->withQueryString();
            } else {
                $query = $query->paginate(10)->withQueryString();
            }
        } else if ($limit) {
            $query = $query->take($limit)->get();
        } else {
            $query = $query->get();
        }

        return $query;
    }

    public static function newVariety(array $data)
    {
        $variety = self::create([
            'name' => $data['name']
        ]);

        if (!empty($data['size_id'])) {
            $variety->sizes()->attach($data['size_id']);
        }
        if (!empty($data['unit_id'])) {
            $variety->units()->attach($data['unit_id']);
        }
        if (!empty($data['packaging_size_id'])) {
            $variety->packaging_sizes()->attach($data['packaging_size_id']);
        }
        if (!empty($data['packaging_material_id'])) {
            $variety->packaging_materials()->attach($data['packaging_material_id']);
        }

        return true;
    }

    public static function findById($id)
    {
        return self::with(['products', 'sizes', 'units', 'packaging_sizes', 'packaging_materials'])->find($id);
    }

    public static function updateVariety(Variety $variety, array $data)
    {
        $variety->update($data);
        if (!empty($data['size_id'])) {
            $variety->sizes()->sync($data['size_id']);
        }
        if (!empty($data['unit_id'])) {
            $variety->units()->sync($data['unit_id']);
        }
        if (!empty($data['packaging_size_id'])) {
            $variety->packaging_sizes()->sync($data['packaging_size_id']);
        }
        if (!empty($data['packaging_material_id'])) {
            $variety->packaging_materials()->sync($data['packaging_material_id']);
        }

        return true;

    }

    public static function deleteVariety(Variety $variety)
    {
        $variety->sizes()->detach();
        $variety->units()->detach();
        $variety->packaging_sizes()->detach();
        $variety->packaging_materials()->detach();

        return $variety->delete();
    }
}
