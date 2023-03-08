<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\OrderStatusImage;
use App\User;

class OrderStatus extends Model
{
    protected $table = 'order_statuses';
    protected $fillable = ['order_id', 'status', 'message', 'location', 'contact', 'user_id'];
    protected $hidden = ['pivot'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orderStatusImages()
    {
        return $this->hasMany(OrderStatusImage::class);
    }

    public function addNewOrderStatus(array $data)
    {
        try {
            \DB::beginTransaction();
            $newOrderStatus = new OrderStatus;
    
            $newOrderStatus->order_id = $data['order_id'];
            $newOrderStatus->user_id = $data['user_id'];
            $newOrderStatus->status = $data['status'];
            $newOrderStatus->message = isset($data['message']) ? $data['message'] : null;
            $newOrderStatus->location = isset($data['location']) ? $data['location'] : null;
            $newOrderStatus->contact = isset($data['contact']) ? $data['contact'] : null;
    
            $newOrderStatus->save();
    
            if (isset($data['image'])) {
                foreach ($data['image'] as $image) {
                    (new OrderStatusImage())->addNewOrderStatusImage($newOrderStatus->id, $image);
                }
            }
            \DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'New notification created successfully'
            ], 200);
        } catch (\Throwable $th) {
            \DB::rollback();
            return response()->json([
                'status' => 400,
                'message' => $th
            ], 400);
        }

    }

    public static function getOrderStatusByFiltering(array $filters, $pagination = true, $limit = false)
    {
        $query = self::with(['orderStatusImages', 'order', 'order.seller', 'order.buyer', 'order.product', 'order.product.adminOfferedProduct', 'order.product.variety', 'order.product.locations', 'order.product.unit', 'order.product.size', 'order.product.packagingMaterial', 'order.product.packagingSize', 'order.product.exportingCountries', 'order.product.ratings', 'order.buyer']);

        if (!empty($filters['id'])) {
            $query = $query->where('id', $filters['id']);
        }

        if (!empty($filters['status'])) {
            $query = $query->where('status', $filters['status']);
        }
        
        if (!empty($filters['user_id'])) {
            $search = $filters['user_id'];
            $query = $query->whereHas('user', function ($query) use ($search) {
                $query->where('id', $search);
            });
        }

        if (!empty($filters['name'])) {
            $search = $filters['name'];
            $query = $query->whereHas('order.product.adminOfferedProduct', function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
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
}
