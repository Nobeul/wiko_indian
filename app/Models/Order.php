<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{
    Product,
    Location,
    OrderStatus,
    OrderStatusImage
};
use App\User;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['seller_id', 'buyer_id', 'product_id', 'shipping_cost', 'location_id', 'quantity', 'price'];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function orderStatuses()
    {
        return $this->hasMany(OrderStatus::class);
    }

    public static function getOrdersByFiltering(array $filters, $pagination = true, $limit = false) 
    {
        $query = self::with(['seller', 'seller.ratings', 'buyer', 'product', 'product.adminOfferedProduct', 'product.variety', 'product.unit', 'product.size', 'product.packagingMaterial', 'product.packagingSize', 'location', 'orderStatuses', 'orderStatuses.orderStatusImages']);
        
        if (!empty($filters['id'])) {
            $query = $query->where('id', $filters['id']);
        }

        if (!empty($filters['seller_id'])) {
            $query = $query->where('seller_id', $filters['seller_id']);
        }

        if (!empty($filters['buyer_id'])) {
            $query = $query->where('buyer_id', $filters['buyer_id']);
        }

        if (!empty($filters['product_id'])) {
            $query = $query->where('product_id', $filters['product_id']);
        }

        if (!empty($filters['location_id'])) {
            $query = $query->where('location_id', $filters['location_id']);
        }

        if (!empty($filters['shipping_cost'])) {
            $query = $query->where('shipping_cost', $filters['shipping_cost']);
        }

        if (!empty($filters['quantity'])) {
            $query = $query->where('quantity', $filters['quantity']);
        }

        if (!empty($filters['price'])) {
            $query = $query->where('price', $filters['price']);
        }

        if (!empty($filters['name'])) {
            $search = $filters['name'];
            $query = $query->whereHas('product.adminOfferedProduct', function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            });
        }

        if (!empty($filters['status'])) {
            $search = $filters['status'];
            $query = $query->whereHas('orderStatuses', function ($query) use ($search) {
                $query->where('status', 'like', '%'.$search.'%');
            });
        }
        

        $query = $query->orderBy('id', 'desc');
        
        if ($pagination === true) {
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

    public function createNewOrder(array $data)
    {
        try {
            \DB::beginTransaction();

            self::create($data);

            \DB::commit();
            
            return response()->json([
                'status' => 200,
                'message' => 'Your order has been added successfully'
            ], 200);
        } catch(\Throwable $th) {
            \DB::rollback();

            return response()->json([
                'status' => 400,
                'message' => $th
            ], 400);
        }
    }
}
