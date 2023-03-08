<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductAttribute;
use App\Models\Product;

class Size extends Model
{
    protected $table    = 'sizes';
    protected $fillable = ['name', 'size_unit'];
    protected $hidden   = ['pivot', 'created_at', 'updated_at'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public static function getSizesByFiltering(array $filters, $pagination = false, $limit = false) 
    {
        $query = self::query();

        if (!empty($filters['id'])) {
            $query = $query->where('id', $filters['id']);
        }

        if (!empty($filters['name'])) {
            $query = $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        if (!empty($filters['size_unit'])) {
            $query = $query->where('size_unit', $filters['size_unit']);
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

    public static function newSize(array $data)
    {
        return self::create([
            'name' => $data['name'],
            'size_unit' => $data['size_unit']
        ]);
    }

    public static function findById($id)
    {
        return self::with('products')->find($id);
    }

    public static function updateSize(Size $size, array $data)
    {
        return $size->update($data);
    }

    public static function deleteSize(Size $size)
    {
        return $size->delete();
    }
}
