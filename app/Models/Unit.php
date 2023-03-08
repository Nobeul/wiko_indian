<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Unit extends Model
{
    protected $table    = 'units';
    protected $fillable = ['name', 'unit'];
    protected $hidden   = ['pivot', 'created_at', 'updated_at'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public static function getUnitsByFiltering(array $filters, $pagination = false, $limit = false) 
    {
        $query = self::query();

        if (!empty($filters['id'])) {
            $query = $query->where('id', $filters['id']);
        }

        if (!empty($filters['name'])) {
            $query = $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        if (!empty($filters['unit'])) {
            $query = $query->where('unit', $filters['unit']);
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

    public static function newUnit(array $data)
    {
        return self::create([
            'name' => $data['name'],
            'unit' => $data['unit']
        ]);
    }

    public static function findById($id)
    {
        return self::with('products')->find($id);
    }

    public static function updateUnit(Unit $unit, array $data)
    {
        return $unit->update($data);
    }

    public static function deleteUnit(Unit $unit)
    {
        return $unit->delete();
    }
}
