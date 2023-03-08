<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\PackagingSize;
use App\Models\PackagingMaterial;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Size;
use App\Models\Unit;
use App\Models\Variety;
use Carbon\Carbon;
use App\Models\AdminOfferedProduct;
use App\Models\ProductImage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->method() == 'POST') {
            return response()->json([
                'status' => 405,
                'message' => 'Method not allowed'
            ], 405);
        }

        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['pagination'] = empty($request->pagination) ? false : (!empty($request->pagination) && $request->pagination == 'true' ? true : false);
        $data['search'] = isset($request->search) ? $request->search : '';
        $data['order_by'] = isset($request->order_by) ? $request->order_by : '';
        $data['order_pattern'] = isset($request->order_pattern) ? $request->order_pattern : '';
        $data['search'] = isset($request->search) ? $request->search : '';
        $data['available_untill'] = Carbon::now()->toDateTime();
        $data['id'] = !empty($request->id) ? $request->id : null;
        $data['name'] = !empty($request->name) ? $request->name : null;
        $data['is_recommended'] = !empty($request->is_recommended) ? $request->is_recommended : null;
        $data['products'] = (new AdminOfferedProduct())::getByFilters($data, $data['pagination'], $data['page_limit']);

        return response()->json([
            'products' => $data['products']
        ], 200);
    }

    public function sellerProductList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seller_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid data',
                'errors' => $validator->errors()
            ], 400);
        }

        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['pagination'] = empty($request->pagination) ? false : (!empty($request->pagination) && $request->pagination == 'true' ? true : false);
        $data['search'] = isset($request->search) ? $request->search : '';
        $data['seller_id'] = isset($request->seller_id) ? $request->seller_id : '';
        $data['order_by'] = isset($request->order_by) ? $request->order_by : '';
        $data['order_pattern'] = isset($request->order_pattern) ? $request->order_pattern : '';
        // $data['location'] = isset($request->location) ? $request->location : '';
        $data['available_untill'] = Carbon::now()->toDateTime();
        $data['products'] = (new Product())::getProductsByFiltering($data, $data['pagination'], $data['page_limit']);

        return response()->json([
            'products' => $data['products']
        ], 200);
    }

    public function create(Request $request)
    {
        if ($request->method() == 'GET') {
            return response()->json([
                'status' => 405,
                'message' => 'Method not allowed'
            ], 405);
        }
        $data['module'] = 'Products';
        $data['sub_module'] = 'Create Product';
        $data['varieties'] = (new Variety())::all();
        $data['locations'] = (new Location())::all();
        $data['sizes'] = (new Size())::all();
        $data['units'] = (new Unit())::all();
        $data['materials'] = (new PackagingMaterial())::all();
        $data['packaging_sizes'] = (new PackagingSize())::all();

        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(), [
                'admin_offered_product_id' => 'required|exists:admin_offered_products,id',
                'price' => 'required|numeric|min:1',
                'transportation_cost' => 'nullable|numeric|min:0',
                'available_quantity' => 'required|numeric|min:1',
                'is_negotiable' => 'required|boolean',
                'unit_id' => 'required|exists:units,id',
                'location_id' => 'required|array',
                'location_id.*' => 'exists:locations,id',
                'size_id' => 'required|exists:sizes,id',
                'variety_id' => 'required|exists:varieties,id',
                'packaging_material_id' => 'required|exists:packaging_materials,id',
                'packaging_size_id' => 'required|exists:packaging_sizes,id',
                'user_id' => 'required|exists:users,id',
                'available_untill' => 'required|after:today|date_format:Y-m-d H:i:s',
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpeg,png,jpg|max:512',
                'country_id' => 'nullable|array',
                'country_id.*' => 'exists:countries,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid data',
                    'errors' => $validator->errors()
                ], 400);
            }

            $create_new_product = (new Product())->newProduct($request->all());
            $status = $create_new_product->getData()->status;
            $message = $create_new_product->getData()->message;
            return response()->json([
                'status' => $status,
                'message' => $message
            ], $status);
        }
    }

    public function edit(Request $request)
    {
        $product = (new Product())::findById($request->id);

        if (empty($product)) {
            return response()->json([
                "status" => 400,
                "message" => 'Product not found'
            ], 400);
        }

        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(), [
                'admin_offered_product_id' => 'required|exists:admin_offered_products,id',
                'price' => 'nullable|numeric|min:1',
                'transportation_cost' => 'nullable|numeric|min:0',
                'available_quantity' => 'nullable|numeric|min:1',
                'is_negotiable' => 'nullable|boolean',
                'unit_id' => 'nullable|exists:units,id',
                'location_id' => 'nullable|array',
                'location_id.*' => 'exists:locations,id',
                'size_id' => 'nullable|exists:sizes,id',
                'variety_id' => 'nullable|exists:varieties,id',
                'packaging_material_id' => 'nullable|exists:packaging_materials,id',
                'packaging_size_id' => 'nullable|exists:packaging_sizes,id',
                'user_id' => 'nullable|exists:users,id',
                'available_untill' => 'nullable|after:today|date_format:Y-m-d H:i:s',
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpeg,png,jpg|max:512',
                'country_id' => 'nullable|array',
                'country_id.*' => 'exists:countries,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid data',
                    'errors' => $validator->errors()
                ], 400);
            }

            $edit_product = (new Product())->editProduct($product, $request->all());

            $status = $edit_product->getData()->status;
            $message = $edit_product->getData()->message;

            return response()->json([
                'status' => $status,
                'message' => $message
            ], $status);
        }
        
        return response()->json([
            'status' => 200,
            'product' => $product
        ], 200);
    }

    public function delete(Request $request)
    {
        if ($request->method() == 'GET') {
            return response()->json([
                'status' => 405,
                'message' => 'Method not allowed'
            ], 405);
        }
        $product = Product::find($request->id);

        if (empty($product)) {
            return response()->json([
                'status' => 400,
                'product' => 'Product not found'
            ], 400);
        }

        // if (count($product->images) > 0) {
        //     $product_images = ProductImage::where('product_id', $product->id)->get();
        //     if (! empty($product_images)) {
        //         foreach($product_images as $image) {
        //             if (file_exists($image)) {
        //                 unlink($image->image);
        //             }
        //         }
        //     }
        //     $product_image = ProductImage::where('product_id', $product->id)->pluck('id')->toArray();
        //     (new ProductImage())->destroy($product_image);
        // }
        $product->status = 0;
        $product->save();
        
        return response()->json([
            'status' => 200,
            'message' => 'Product deleted successfully'
        ], 200);
    }

    public function filterForBuyer(Request $request)
    {
        if ($request->method() == 'POST') {
            return response()->json([
                'status' => 405,
                'message' => 'Method not allowed'
            ], 405);
        }

        $validator = Validator::make($request->all(), [
            'admin_offered_product_id' => 'nullable|exists:admin_offered_products,id',
            'variety_id' => 'nullable|exists:varieties,id',
            'size_id' => 'nullable|exists:sizes,id',
            'unit_id' => 'nullable|exists:units,id',
            'packaging_size_id' => 'nullable|exists:packaging_sizes,id',
            'packaging_material_id' => 'nullable|exists:packaging_materials,id',
            'location_id' => 'nullable|array',
            'location_id.*' => 'exists:locations,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid data',
                'errors' => $validator->errors()
            ], 400);
        }

        $request['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $request['pagination'] = empty($request->pagination) ? false : (!empty($request->pagination) && $request->pagination == 'true' ? true : false);
        $products = (new Product())->getProductsByFiltering($request->all()); 

        return response()->json([
            'status' => 200,
            'products' => $products
        ], 200);
    }
}
