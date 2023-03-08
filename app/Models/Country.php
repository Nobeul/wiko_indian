<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\User;

class Country extends Model
{
    protected $table    = 'countries';
    protected $hidden = ['pivot'];
    protected $fillable = ['status'];
    public $timestamps  = false;

    public function user_detail()
    {
        return $this->hasOne(User::class, 'country_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_countries');
    }

    public static function getCountriesByFiltering(array $filters, $pagination = false, $limit = false) 
    {
        $query = self::query();

        if (!empty($filters['id'])) {
            $query = $query->where('id', $filters['id']);
        }

        if (!empty($filters['name'])) {
            $query = $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        if (!empty($filters['status'])) {
            $query = $query->where('status', $filters['status']);
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

    public static function findById($id)
    {
        return self::with('products')->where('id', $id)->first();
    }

    public static function updateCountry(Country $country, array $data)
    {
        return $country->update($data);
    } 
}