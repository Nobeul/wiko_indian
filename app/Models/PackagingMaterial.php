<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PackagingSize;

class PackagingMaterial extends Model
{
    protected $table    = 'packaging_materials';
    protected $fillable = ['name', 'packaging_size_id'];
    protected $hidden   = ['pivot', 'created_at', 'updated_at'];

    public static function getPackagingMaterialsByFiltering(array $filters, $pagination = false, $limit = false) 
    {
        $query = self::query();

        if (!empty($filters['id'])) {
            $query = $query->where('id', $filters['id']);
        }

        if (!empty($filters['name'])) {
            $query = $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        if (!empty($filters['with'])) {
            $query->with($filters['with']);
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

    public static function newPackagingMaterial(array $data)
    {
        return self::create([
            'name' => $data['name'],
        ]);
    }

    public static function findById($id)
    {
        return self::find($id);
    }

    public static function updatePackagingMaterial(PackagingMaterial $packaging_material, array $data)
    {
        return $packaging_material->update($data);
    }

    public static function deletePackagingMaterial(PackagingMaterial $packaging_material)
    {
        return $packaging_material->delete();
    }

    // public function packagingSize()
    // {
    //     return $this->belongsTo(PackagingSize::class, 'packaging_size_id');
    // }
}
