<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderStatus;

class OrderStatusImage extends Model
{
    protected $table = 'order_status_images';
    protected $fillable = ['order_status_id', 'image'];
    protected $hidden = ['created_at', 'updated_at'];

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id', 'id');
    }

    public function addNewOrderStatusImage($order_status_id, $image)
    {
        $imageName = time().rand(1,10000).'.'.$image->extension();
     
        $image->move(public_path('admin/assets/img/notification/'), $imageName);

        $order_status_image = new OrderStatusImage();
        $order_status_image->order_status_id = $order_status_id;
        $order_status_image->image = asset('public/admin/assets/img/notification/'.$imageName);
        $order_status_image->save();
    }
}
