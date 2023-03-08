<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;
class PackagingSize extends Model
{
    protected $table    = 'packaging_sizes';
    protected $fillable = ['name', 'unit_id'];
    protected $hidden   = ['pivot', 'created_at', 'updated_at'];

    public static function getPackagingSizesByFiltering(array $filters, $pagination = false, $limit = false) 
    {
        $query = self::query();

        if (!empty($filters['id'])) {
            $query = $query->where('id', $filters['id']);
        }

        if (!empty($filters['name'])) {
            $query = $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        if (!empty($filters['unit_id'])) {
            $query = $query->where('unit_id', $filters['unit_id']);
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

    public static function newPackagingSize(array $data)
    {
        return self::create([
            'name' => $data['name'],
            'unit_id' => $data['unit_id']
        ]);
    }

    public static function findById($id)
    {
        return self::find($id);
    }

    public static function updatePackagingSize(PackagingSize $packaging_size, array $data)
    {
        return $packaging_size->update($data);
    }

    public static function deletePackagingSize(PackagingSize $packaging_size)
    {
        return $packaging_size->delete();
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
