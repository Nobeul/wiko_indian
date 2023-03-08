<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $data['module'] = 'Settings';
        $data['sub_module'] = 'Locations';
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['locations'] = (new Location())::getLocationsByFiltering([], true, $data['page_limit']);

        return view('admin.locations.index', $data);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:locations',
            'country' => 'required'
        ]);

        if ($validator->fails()) {
            one_time_message('danger', $validator->errors()->first());
            return redirect()->back();
        }
        (new Location())->newLocation($request->all());

        one_time_message('success', 'A new location created successfully');
        return redirect()->back();
    }

    public function edit(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:locations,name,'.$request->id,
            'country' => 'required'
        ]);

        if ($validator->fails()) {
            one_time_message('danger', $validator->errors()->first());
            return redirect()->back();
        }
        
        $location = (new Location())::findById($request->id);
        if (empty($location)) {
            one_time_message('danger', 'Location not found');
            return redirect()->back();
        }
        (new Location())::updateLocation($location, $request->all());

        one_time_message('success', 'Location updated successfully');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $location = (new Location())::findById($request->id);

        if (empty($location)) {
            one_time_message('danger', 'Location not found');
            return redirect()->back();
        }
        
        if (count($location->products) == 0) {
            (new Location())::deleteLocation($location);
        } else {
            one_time_message('danger', 'Can not delete this. This has been used for product');
            return redirect()->back();
        }

        one_time_message('success', 'Location deleted successfully');
        return redirect()->back();
    }
}
