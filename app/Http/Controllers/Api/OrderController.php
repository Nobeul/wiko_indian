<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderStatusImage;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        if ($request->method() == 'GET') {
            return response()->json([
                'status' => 405,
                'message' => 'Method not allowed'
            ], 405);
        }

        $validator = Validator::make($request->all(), [
            'seller_id' => 'required|exists:users,id',
            'buyer_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'location_id' => 'required|exists:locations,id',
            'shipping_cost' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:1',
            // 'discount' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid data',
                'errors' => $validator->errors()
            ], 400);
        }

        if ($request->seller_id == $request->buyer_id) {
            return response()->json([
                'status' => 400,
                'message' => 'Buyer and seller can not be the same person'
            ], 400);
        }
        $order = (new Order())->createNewOrder($request->only('seller_id', 'buyer_id', 'product_id', 'location_id', 'shipping_cost', 'price', 'quantity'));

        return response()->json([
            'status' => $order->getData()->status,
            'message' => $order->getData()->message
        ], $order->getData()->status);
    }

    public function index(Request $request)
    {
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['name'] = isset($request->name) ? $request->name : '';
        $data['status'] = isset($request->status) ? $request->status : '';
        $data['orders'] = (new Order())::getOrdersByFiltering($request->all(), true, $data['page_limit']);

        return response()->json([
            'status' => 200,
            'orders' => $data['orders']
        ], 200);
    }

    public function createNotification(Request $request)
    {
        if ($request->method() == 'GET') {
            return response()->json([
                'status' => 405,
                'message' => 'Method not allowed'
            ], 405);
        }

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'user_id' => 'required|exists:users,id',
            'status' => 'required',
            'message' => 'nullable',
            'location' => 'nullable',
            'contact' => 'nullable',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg|max:512'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid data',
                'errors' => $validator->errors()
            ], 400);
        }

        $data = $request->only('order_id', 'status', 'message', 'location', 'contact', 'image', 'user_id');

        $orderStatus = (new OrderStatus())->addNewOrderStatus($data);

        return response()->json([
            'status' => $orderStatus->getData()->status,
            'message' => $orderStatus->getData()->message
        ], $orderStatus->getData()->status);
    }

    public function viewNotification()
    {
        if (request()->method() == 'POST') {
            return response()->json([
                'status' => 405,
                'message' => 'Method not allowed'
            ], 405);
        }

        $notification = (new OrderStatus())::with(['order', 'orderStatusImages', 'order.buyer', 'order.product', 'order.product.adminOfferedProduct'])->where(request()->all())->first();

        if (empty($notification)) {
            return response()->json([
                'status' => 400,
                'message' => 'Notification not found'
            ], 400);
        }

        return response()->json([
            'status' => 200,
            'notification' => $notification
        ], 200);
    }

    public function getNotifications(Request $request)
    {
        if (request()->method() == 'POST') {
            return response()->json([
                'status' => 405,
                'message' => 'Method not allowed'
            ], 405);
        }
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['name'] = isset($request->name) ? $request->name : '';
        $data['order_statuses'] = (new OrderStatus())::getOrderStatusByFiltering($request->all(), true, $data['page_limit']);

        return response()->json([
            'status' => 1,
            'notifications' => $data['order_statuses']
        ], 200);
    }
}
