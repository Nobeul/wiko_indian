<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Location extends Model
{
    protected $table    = 'locations';
    protected $fillable = ['name', 'country', 'city', 'state', 'address'];
    protected $hidden   = ['pivot', 'created_at', 'updated_at'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_locations');
    }

    public static function getLocationsByFiltering(array $filters, $pagination = false, $limit = false) 
    {
        $query = self::query();

        if (!empty($filters['id'])) {
            $query = $query->where('id', $filters['id']);
        }

        if (!empty($filters['name'])) {
            $query = $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        if (!empty($filters['country'])) {
            $query = $query->where('country', 'like', '%'.$filters['country'].'%');
        }

        if (!empty($filters['city'])) {
            $query = $query->where('city', 'like', '%'.$filters['city'].'%');
        }

        if (!empty($filters['state'])) {
            $query = $query->where('state', 'like', '%'.$filters['state'].'%');
        }

        // if (!empty($filters['address'])) {
        //     $query = $query->where('address', 'like', '%'.$filters['address'].'%');
        // }

        if (!empty($filters['searchkey'])) {
            $query = $query->where('name', 'like', '%'.$filters['searchkey'].'%')
                    ->orWhere('country', 'like', '%'.$filters['searchkey'].'%')
                    ->orWhere('city', 'like', '%'.$filters['searchkey'].'%')
                    ->orWhere('state', 'like', '%'.$filters['searchkey'].'%');
                    // ->orWhere('address', 'like', '%'.$filters['searchkey'].'%');

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

    public static function newLocation(array $data)
    {
        return self::create([
            'name' => $data['name'],
            'country' => $data['country'],
            'city' => $data['city'],
            'state' => $data['state'],
            'address' => $data['address']
        ]);
    }

    public static function findById($id)
    {
        return self::with('products')->find($id);
    }

    public static function updateLocation(Location $location, array $data)
    {
        return $location->update($data);
    }

    public static function deleteLocation(Location $location)
    {
        return $location->delete();
    }
}
