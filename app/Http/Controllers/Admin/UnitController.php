<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\PackagingSize;


class UnitController extends Controller
{
    public function index(Request $request)
    {
        $data['module'] = 'Settings';
        $data['sub_module'] = 'Units';
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['units'] = (new Unit())::getUnitsByFiltering([], true, $data['page_limit']);

        return view('admin.units.index', $data);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:units',
            'unit' => 'required'
        ]);

        if ($validator->fails()) {
            one_time_message('danger', $validator->errors()->first());
            return redirect()->back();
        }
        (new Unit())->newUnit($request->all());

        one_time_message('success', 'A new unit created successfully');
        return redirect()->back();
    }

    public function edit(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:units,name,'.$request->id,
            'unit' => 'required'
        ]);

        if ($validator->fails()) {
            one_time_message('danger', $validator->errors()->first());
            return redirect()->back();
        }
        
        $unit = (new Unit())::findById($request->id);
        if (empty($unit)) {
            one_time_message('danger', 'Unit not found');
            return redirect()->back();
        }
        (new Unit())::updateUnit($unit, ['name' => $request->name, 'unit' => $request->unit]);

        one_time_message('success', 'Unit updated successfully');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $unit = (new Unit())::findById($request->id);

        if (empty($unit)) {
            one_time_message('danger', 'Unit not found');
            return redirect()->back();
        }
        $packaging_sizes = PackagingSize::where(['unit_id' => $unit->id])->get();
        if (count($packaging_sizes) > 0) {
            one_time_message('danger', 'Can not delete this. This has been used in packaging size');
            return redirect()->back();
        }
        if (count($unit->products) == 0) {
            (new Unit())::deleteUnit($unit);
        } else {
            one_time_message('danger', 'Can not delete this. This has been used for product');
            return redirect()->back();
        }

        one_time_message('success', 'Unit deleted successfully');
        return redirect()->back();
    }
}
