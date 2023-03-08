<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Variety,
    Size,
    Unit,
    PackagingSize,
    PackagingMaterial
};


class VarietyController extends Controller
{
    public function index(Request $request)
    {
        $data['module'] = 'Settings';
        $data['sub_module'] = 'Varieties';
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['varieties'] = (new Variety())::getVarietiesByFiltering([], true, $data['page_limit']);
        $data['sizes'] = (new Size())::all();
        $data['units'] = (new Unit())::all();
        $data['packaging_sizes'] = (new PackagingSize())::all();
        $data['packaging_materials'] = (new PackagingMaterial())::all();
        $data['sizes'] = (new Size())::all();

        return view('admin.varieties.index', $data);
    }

    public function create(Request $request)
    {
        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:varieties',
                'unit_id' => 'nullable|array',
                'unit_id.*' => 'exists:units,id',
                'size_id' => 'nullable|array',
                'size_id.*' => 'exists:sizes,id',
                'packaging_material_id' => 'nullable|array',
                'packaging_material_id.*' => 'exists:packaging_materials,id',
                'packaging_size_id' => 'nullable|array',
                'packaging_size_id.*' => 'exists:packaging_sizes,id',
            ]);
            if ($validator->fails()) {
                one_time_message('danger', $validator->errors()->first());
                return redirect()->back();
            }
            (new Variety())->newVariety($request->all());
    
            one_time_message('success', 'A new variety created successfully');
            return redirect()->to('varieties');
        }

        $data['module'] = 'Settings';
        $data['sub_module'] = 'Create New Variety';
        $data['sizes'] = (new Size())::all();
        $data['units'] = (new Unit())::all();
        $data['packaging_sizes'] = (new PackagingSize())::all();
        $data['packaging_materials'] = (new PackagingMaterial())::all();
        $data['sizes'] = (new Size())::all();

        return view('admin.varieties.create', $data);
    }

    public function edit(Request $request) 
    {
        $data['variety'] = $variety = (new Variety())::findById($request->id);
        if (empty($variety)) {
            one_time_message('danger', 'Variety not found.');
            return redirect()->back();
        }
        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:varieties,name,'.$request->id,
                'unit_id' => 'nullable|array',
                'unit_id.*' => 'exists:units,id',
                'size_id' => 'nullable|array',
                'size_id.*' => 'exists:sizes,id',
                'packaging_material_id' => 'nullable|array',
                'packaging_material_id.*' => 'exists:packaging_materials,id',
                'packaging_size_id' => 'nullable|array',
                'packaging_size_id.*' => 'exists:packaging_sizes,id',
            ]);
    
            if ($validator->fails()) {
                one_time_message('danger', $validator->errors()->first());
                return redirect()->back();
            }
            
            if (empty($variety)) {
                one_time_message('danger', 'Variety not found');
                return redirect()->back();
            }
            (new Variety())::updateVariety($variety, $request->all());
    
            one_time_message('success', 'Variety updated successfully');
            return redirect()->to('varieties');
        }

        $data['module'] = 'Settings';
        $data['sub_module'] = 'Edit Variety';
        $data['sizes'] = (new Size())::all();
        $data['units'] = (new Unit())::all();
        $data['packaging_materials'] = (new PackagingMaterial())::all();
        $data['packaging_sizes'] = (new PackagingSize())::all();
        $data['variety_sizes'] = $variety->sizes->pluck('id')->toArray();
        $data['variety_units'] = $variety->units->pluck('id')->toArray();
        $data['variety_packaging_materials'] = $variety->packaging_materials->pluck('id')->toArray();
        $data['variety_packaging_sizes'] = $variety->packaging_sizes->pluck('id')->toArray();

        return view('admin.varieties.edit', $data);
    }

    public function delete(Request $request)
    {
        $variety = (new Variety())::findById($request->id);

        if (empty($variety)) {
            one_time_message('danger', 'Variety not found');
            return redirect()->back();
        }
        if (count($variety->products) == 0) {
            (new Variety())::deleteVariety($variety);
        } else {
            one_time_message('danger', 'Can not delete this. This has been used for product');
            return redirect()->back();
        }

        one_time_message('success', 'Variety deleted successfully');
        return redirect()->back();
    }
}
