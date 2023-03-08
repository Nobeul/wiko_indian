<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    PackagingSize,
    Unit,
    PackagingMaterial
};

class PackagingSizeController extends Controller
{
    public function index(Request $request)
    {
        $data['module'] = 'Settings';
        $data['sub_module'] = 'Packaging Sizes';
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['packaging_sizes'] = (new PackagingSize())::getPackagingSizesByFiltering(['with' => 'unit'], true, $data['page_limit']);
        $data['units'] = (new Unit())::all();

        return view('admin.packaging_sizes.index', $data);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:packaging_sizes',
            'unit_id' => 'required'
        ]);

        if ($validator->fails()) {
            one_time_message('danger', $validator->errors()->first());
            return redirect()->back();
        }
        (new PackagingSize())->newPackagingSize($request->all());

        one_time_message('success', 'A new packaging size created successfully');
        return redirect()->back();
    }

    public function edit(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:packaging_sizes,name,'.$request->id,
            'unit_id' => 'required'
        ]);

        if ($validator->fails()) {
            one_time_message('danger', $validator->errors()->first());
            return redirect()->back();
        }

        $packaging_size = (new PackagingSize())::findById($request->id);
        if (empty($packaging_size)) {
            one_time_message('danger', 'Packaging size not found');
            return redirect()->back();
        }
        (new PackagingSize())::updatePackagingSize($packaging_size, ['name' => $request->name, 'unit_id' => $request->unit_id]);

        one_time_message('success', 'Packaging size updated successfully');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $packaging_size = (new PackagingSize())::findById($request->id);

        if (empty($packaging_size)) {
            one_time_message('danger', 'Packaging size not found');
            return redirect()->back();
        }
        
        $packaging_materials = PackagingMaterial::where(['packaging_size_id' => $packaging_size->id])->get();
        if (count($packaging_materials) > 0) {
            one_time_message('danger', 'Can not delete this. This has been used in packaging material');
            return redirect()->back();
        }

        if (empty($packaging_size->products)) {
            (new PackagingSize())::deletePackagingSize($packaging_size);
        } else {
            one_time_message('danger', 'Can not delete this. This has been used for product');
            return redirect()->back();
        }

        one_time_message('success', 'Packaging size deleted successfully');
        return redirect()->back();
    }
}
