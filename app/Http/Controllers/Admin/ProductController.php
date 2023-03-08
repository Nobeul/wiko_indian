<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\PackagingSize;
use App\Models\PackagingMaterial;
use App\Models\AdminOfferedProduct;
use App\Models\ProductAttribute;
use App\Models\Product;
use App\Models\Size;
use App\Models\Unit;
use App\Models\Variety;
use App\User;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $data['module'] = 'Products';
        $data['sub_module'] = 'List';
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['name'] = isset($request->name) ? $request->name : null;
        $data['products'] = (new AdminOfferedProduct())::getByFilters(['name' => $data['name']], true, $data['page_limit']);

        return view('admin.products.index', $data);
    }

    public function create(Request $request)
    {
        $data['module'] = 'Products';
        $data['sub_module'] = 'Create Product';
        $data['varieties'] = (new Variety())::all();
        $data['locations'] = (new Location())::all();
        $data['sizes'] = (new Size())::all();
        $data['units'] = (new Unit())::all();
        $data['materials'] = (new PackagingMaterial())::all();
        $data['packaging_sizes'] = (new PackagingSize())::all();
        $data['users'] = (new User())::where(['user_type' => 1])->get();

        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:admin_offered_products',
                // 'is_recommended' => 'required',
                'variety_id' => 'required|array',
                'variety_id.*' => 'exists:varieties,id'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $product = (new AdminOfferedProduct())->createNewProduct($validator->validated());

            one_time_message('success', 'A new product has been created');

            return redirect()->to('products');
        }
        
        return view('admin.products.create', $data);
    }

    public function edit(Request $request)
    {
        $data['module'] = 'Products';
        $data['sub_module'] = 'Edit Product';
        $data['product'] = $products = (new AdminOfferedProduct())::find($request->id);
        $data['varieties'] = (new Variety())::all();
        $data['product_varieties'] = $products->varieties->pluck('id')->toArray();

        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:admin_offered_products,name,'.$request->id,
                'is_recommended' => 'required',
                'variety_id' => 'required|array',
                'variety_id.*' => 'exists:varieties,id',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            (new AdminOfferedProduct())->editProduct($data['product'], $request->all());

            one_time_message('success', 'Product updated successfully');
            return redirect()->to('products');
        }
        
        return view('admin.products.edit', $data);
    }

    public function delete(Request $request)
    {
        $product = AdminOfferedProduct::find($request->id);

        if (empty($product)) {
            one_time_message('danger', 'Product not found');
            return redirect()->back();
        }

        (new AdminOfferedProduct())->deleteProduct($product);
        
        one_time_message('success', 'Product deleted successfully');
        return redirect()->back();
    }

    public function showProductDetails(Request $request)
    {
        $data['module'] = 'Products';
        $data['sub_module'] = 'Product Details';
        $data['product'] = $product = AdminOfferedProduct::find($request->id);

        if (empty($product)) {
            one_time_message('danger', 'Product not found');
            return redirect()->back();
        }

        return  view('admin.products.view', $data);

    }

    public function showProductsSellingToday(Request $request)
    {
        $data['module'] = 'Products Selling Today';
        $data['sub_module'] = 'List';
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['name'] = isset($request->name) ? $request->name : null;
        $data['user_id'] = isset($request->user_id) ? $request->user_id : null;
        $data['available_untill'] = Carbon::now()->toDateTime();
        $data['products'] = (new Product())->getProductsByFiltering(['name' => $data['name'], 'user_id' => $data['user_id'], 'available_untill' => $data['available_untill']], true, $data['page_limit']);
        $data['unique_sellers'] = Product::get()->unique('user_id');
        
        return view('admin.products.perday_view', $data);
    }

    public function expiredProducts(Request $request)
    {
        $data['module'] = 'Expired Products';
        $data['sub_module'] = 'List';
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['name'] = isset($request->name) ? $request->name : null;
        $data['user_id'] = isset($request->user_id) ? $request->user_id : null;
        $data['products'] = (new Product())->getProductsByFiltering(['name' => $data['name'], 'user_id' => $data['user_id'], 'expired_product' => true], true, $data['page_limit']);
        $data['unique_sellers'] = Product::where('available_untill', '<=', Carbon::now())->get()->unique('user_id');
        
        return view('admin.products.expired_products_view', $data);
    }
}
