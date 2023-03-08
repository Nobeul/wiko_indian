<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Variety;

class AdminOfferedProduct extends Model
{
    protected $table    = 'admin_offered_products';
    protected $fillable = ['name'];
    protected $hidden = ['pivot'];

    public function varieties()
    {
        return $this->belongsToMany(Variety::class, 'admin_products_variety');
    }

    public static function getByFilters(array $filters, $pagination = false, $limit = false)
    {
        $query = self::query();

        $query = $query->with(['varieties', 'varieties.sizes', 'varieties.units', 'varieties.packaging_sizes', 'varieties.packaging_materials']);

        if (!empty($filters['id'])) {
            $query = $query->where('id', $filters['id']);
        }

        if (!empty($filters['name'])) {
            $query = $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        // if (!empty($filters['is_recommended'])) {
        //     $query = $query->where('is_recommended', $filters['is_recommended']);
        // }

        if (!empty($filters['order_pattern'])) {
            $order_pattern = strtolower($filters['order_pattern']) == 'asc' ? 'asc' : 'desc';
            if (!empty($filters['order_by'])) {
                $query = $query->orderBy($filters['order_by'], $order_pattern);
            }
        } else {
            if (!empty($filters['order_by'])) {
                $query = $query->orderBy($filters['order_by'], 'desc');
            } else {
                $query = $query->orderBy('id', 'desc');
            }
        }

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

    public function createNewProduct(array $data)
    {
        $product = self::create([
            'name' => $data['name'],
            //'is_recommended' => $data['is_recommended']
        ]);

        $product->varieties()->attach($data['variety_id']);

        return true;
    }

    public function editProduct(AdminOfferedProduct $product, array $data)
    {
        $product->name = $data['name'];

        // if (!empty($data['is_recommended'])) {
        //     $product->is_recommended = $data['is_recommended'];
        // }
        
        $product->save();

        $product->varieties()->sync($data['variety_id']);
    }

    public function deleteProduct(AdminOfferedProduct $product)
    {
        $product->varieties()->detach();

        $product->delete();

        return true;
    }
}
