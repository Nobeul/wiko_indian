<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $data['module'] = 'Settings';
        $data['sub_module'] = 'Country List';
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['countries'] = (new Country())::getCountriesByFiltering([], true, $data['page_limit']);

        return view('admin.countries.index', $data); 
    }

    public function edit(Request $request)
    {
        $country = (new Country())::findById($request->id);
        if (empty($country)) {
            one_time_message('danger', 'Country not found');
            return redirect()->back();
        }
        (new Country())::updateCountry($country, ['status' => $request->status]);

        one_time_message('success', 'Country has been updated');
        return redirect()->back();
    }
}
