<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{
    public function index(Request $request)
    {
        $data['module'] = 'Settings';
        $data['sub_module'] = 'Sizes';
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['sizes'] = (new Size())::getSizesByFiltering([], true, $data['page_limit']);

        return view('admin.sizes.index', $data);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:sizes',
            'size_unit' => 'required'
        ]);

        if ($validator->fails()) {
            one_time_message('danger', $validator->errors()->first());
            return redirect()->back();
        }
        (new Size())->newSize($request->all());

        one_time_message('success', 'A new size created successfully');
        return redirect()->back();
    }

    public function edit(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:sizes,name,'.$request->id,
            'size_unit' => 'required'
        ]);

        if ($validator->fails()) {
            one_time_message('danger', $validator->errors()->first());
            return redirect()->back();
        }
        
        $size = (new Size())::findById($request->id);
        if (empty($size)) {
            one_time_message('danger', 'Size not found');
            return redirect()->back();
        }
        (new Size())::updateSize($size, ['name' => $request->name, 'size_unit' => $request->size_unit]);

        one_time_message('success', 'Size updated successfully');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $size = (new Size())::findById($request->id);

        if (empty($size)) {
            one_time_message('danger', 'Size not found');
            return redirect()->back();
        }
        
        if (count($size->products) == 0) {
            (new Size())::deleteSize($size);
        } else {
            one_time_message('danger', 'Can not delete this. This has been used for product');
            return redirect()->back();
        }

        one_time_message('success', 'Size deleted successfully');
        return redirect()->back();
    }
}
