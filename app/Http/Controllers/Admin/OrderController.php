<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $data['module'] = 'Orders';
        $data['sub_module'] = 'List';
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['search'] = isset($request->search) ? $request->search : '';
        $data['orders'] = (new Order())::getOrdersByFiltering($request->all(), true, $data['page_limit']);

        return view('admin.orders.index', $data);
    }
}
