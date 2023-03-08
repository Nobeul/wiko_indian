<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\User;

class Rating extends Model
{
    protected $table = 'ratings';
    protected $fillable = ['user_id', 'product_id', 'rating', 'comment'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::Class);
    }

    public function createNewRating(array $data, $add_for = 'product')
    {
        if ($add_for == 'product') {
            if (empty($data['product_id'])) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Product id is required'
                ], 400);
            }
        } else {
            if (empty($data['user_id'])) {
                return response()->json([
                    'status' => 400,
                    'message' => 'User id is required'
                ], 400);
            }
        }

        try {
            \DB::beginTransaction();

            self::create($data);

            \DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'New review has been added'
            ], 200);
        } catch (\Throwable $th) {
            \DB::rollback();
            return response()->json([
                'status' => 400,
                'message' => $th
            ], 400);
        }
    }

    public static function getAllRatings(array $filters, $pagination = false, $limit = false, $filter_for = 'product')
    {
        $query = self::query();

        if ($filter_for == 'product') {
            $query = $query->with('product')->whereNotNull('product_id');
        } else {
            $query = $query->with('user')->whereNotNull('user_id');
        }
        if (!empty($filters['product_id'])) {
            $query = $query->where('product_id', $filters['product_id']);
        }
        
        if (!empty($filters['product_id'])) {
            $query = $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['rating'])) {
            $query = $query->where('rating', $filters['rating']);
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
}
