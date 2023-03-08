<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->method() == 'POST') {
            return response()->json([
                'status' => 400,
                'message' => 'Method not allowed'
            ],400);
        }
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['countries'] = (new Country())::getCountriesByFiltering([], true, $data['page_limit']);

        return response()->json([
            'status' => 200,
            'countries' => $data['countries']
        ], 200);
    }
}
