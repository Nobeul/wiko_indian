<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Order;
use App\Models\ActivityLog;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['module'] = 'Home';
        $data['sub_module'] = 'Dashboard';
        $data['activity_logs'] = ActivityLog::getActivityLogsByFiltering([], false, 5);
        $data['total_user'] = count(User::get()) > 1 ? count(User::get()) - 1 : count(User::get());
        $data['total_product'] = count(Product::get());
        $data['total_seller'] = count(User::where(['user_type' => 1])->get());
        $data['total_buyer'] = count(User::where(['user_type' => 2])->get());
        $data['total_order'] = count(Order::get());
        $data['product_6'] = count(Product::where('created_at', '>=', $this->getStartDateByTerms(6))->where('created_at', '<=', $this->getEndDateByTerms(6))->get());
        $data['product_5']= count(Product::where('created_at', '>=', $this->getStartDateByTerms(5))->where('created_at', '<=', $this->getEndDateByTerms(5))->get());
        $data['product_4'] = count(Product::where('created_at', '>=', $this->getStartDateByTerms(4))->where('created_at', '<=', $this->getEndDateByTerms(6))->get());
        $data['product_3']= count(Product::where('created_at', '>=', $this->getStartDateByTerms(3))->where('created_at', '<=', $this->getEndDateByTerms(5))->get());
        $data['product_2']= count(Product::where('created_at', '>=', $this->getStartDateByTerms(2))->where('created_at', '<=', $this->getEndDateByTerms(5))->get());
        $data['product_1'] = count(Product::where('created_at', '>=', $this->getStartDateByTerms(1))->where('created_at', '<=', $this->getEndDateByTerms(6))->get());
        $data['product_0']= count(Product::where('created_at', '>=', $this->getStartDateByTerms(0))->where('created_at', '<=', $this->getEndDateByTerms(0))->get());
        $data['order_6'] = count(Order::where('created_at', '>=', $this->getStartDateByTerms(6))->where('created_at', '<=', $this->getEndDateByTerms(6))->get());
        $data['order_5']= count(Order::where('created_at', '>=', $this->getStartDateByTerms(5))->where('created_at', '<=', $this->getEndDateByTerms(5))->get());
        $data['order_4'] = count(Order::where('created_at', '>=', $this->getStartDateByTerms(4))->where('created_at', '<=', $this->getEndDateByTerms(6))->get());
        $data['order_3']= count(Order::where('created_at', '>=', $this->getStartDateByTerms(3))->where('created_at', '<=', $this->getEndDateByTerms(5))->get());
        $data['order_2']= count(Order::where('created_at', '>=', $this->getStartDateByTerms(2))->where('created_at', '<=', $this->getEndDateByTerms(5))->get());
        $data['order_1'] = count(Order::where('created_at', '>=', $this->getStartDateByTerms(1))->where('created_at', '<=', $this->getEndDateByTerms(6))->get());
        $data['order_0']= count(Order::where('created_at', '>=', $this->getStartDateByTerms(0))->where('created_at', '<=', $this->getEndDateByTerms(0))->get());
        $products = (new Product())->getProductsByFiltering(['available_untill' => Carbon::now()->toDateTime()]);
        $data['products_selling_today_count'] = count($products);
        
        return view('home', $data);
    }

    public function getStartDateByTerms($sub_month)
    {
        return \Carbon\Carbon::now()->subMonth($sub_month)->startOfMonth('Y-m-d')->toDateTimeString();
    }

    public function getEndDateByTerms($sub_month)
    {
        return \Carbon\Carbon::now()->subMonth($sub_month)->endOfMonth('Y-m-d')->toDateTimeString();
    }
}
