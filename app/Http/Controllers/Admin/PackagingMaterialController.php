<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    PackagingMaterial,
    PackagingSize
};

class PackagingMaterialController extends Controller
{
    public function index(Request $request)
    {
        $data['module'] = 'Settings';
        $data['sub_module'] = 'Packaging Materials';
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['packaging_materials'] = (new PackagingMaterial())::getPackagingMaterialsByFiltering([], true, $data['page_limit']);
        $data['packaging_sizes'] = (new PackagingSize())::all();

        return view('admin.packaging_materials.index', $data);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:packaging_materials',
        ]);

        if ($validator->fails()) {
            one_time_message('danger', $validator->errors()->first());
            return redirect()->back();
        }
        (new PackagingMaterial())->newPackagingMaterial($request->all());

        one_time_message('success', 'A new packaging material created successfully');
        return redirect()->back();
    }

    public function edit(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:packaging_materials,name,'.$request->id,
        ]);

        if ($validator->fails()) {
            one_time_message('danger', $validator->errors()->first());
            return redirect()->back();
        }

        $packaging_material = (new PackagingMaterial())::findById($request->id);
        if (empty($packaging_material)) {
            one_time_message('danger', 'Packaging material not found');
            return redirect()->back();
        }
        (new PackagingMaterial())::updatePackagingMaterial($packaging_material, ['name' => $request->name, 'packaging_size_id' => $request->packaging_size_id]);

        one_time_message('success', 'Packaging material updated successfully');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $packaging_material = (new PackagingMaterial())::findById($request->id);

        if (empty($packaging_material)) {
            one_time_message('danger', 'Packaging material not found');
            return redirect()->back();
        }
        if (empty($packaging_material->products)) {
            (new PackagingMaterial())::deletePackagingMaterial($packaging_material);
        } else {
            one_time_message('danger', 'Can not delete this. This has been used for product');
            return redirect()->back();
        }

        one_time_message('success', 'Packaging material deleted successfully');
        return redirect()->back();
    }
}
