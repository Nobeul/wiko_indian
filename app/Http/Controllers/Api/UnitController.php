<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Size;
use App\Models\PackagingSize;
use App\Models\PackagingMaterial;
use App\Models\Location;
use App\Models\Variety;
use App\Models\ActivityLog;

class UnitController extends Controller
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
        $data['pagination'] = empty($request->pagination) ? false : (!empty($request->pagination) && $request->pagination == 'true' ? true : false);
        $data['units'] = (new Unit())::getUnitsByFiltering($request->all(), $data['pagination'], $data['page_limit']);

        return response()->json([
            'status' => 200,
            'units' => $data['units']
        ], 200);
    }

    public function getSizes(Request $request)
    {
        if ($request->method() == 'POST') {
            return response()->json([
                'status' => 400,
                'message' => 'Method not allowed'
            ],400);
        }
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['pagination'] = empty($request->pagination) ? false : (!empty($request->pagination) && $request->pagination == 'true' ? true : false);
        $data['sizes'] = (new Size())::getSizesByFiltering($request->all(), $data['pagination'], $data['page_limit']);

        return response()->json([
            'status' => 200,
            'sizes' => $data['sizes']
        ], 200);
    }

    public function getPackagingSizes(Request $request)
    {
        if ($request->method() == 'POST') {
            return response()->json([
                'status' => 400,
                'message' => 'Method not allowed'
            ],400);
        }
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['pagination'] = empty($request->pagination) ? false : (!empty($request->pagination) && $request->pagination == 'true' ? true : false);
        $data['packaging_sizes'] = (new PackagingSize())::getPackagingSizesByFiltering($request->all(), $data['pagination'], $data['page_limit']);

        return response()->json([
            'status' => 200,
            'packaging_sizes' => $data['packaging_sizes']
        ], 200);
    }

    public function getPackagingMaterials(Request $request)
    {
        if ($request->method() == 'POST') {
            return response()->json([
                'status' => 400,
                'message' => 'Method not allowed'
            ],400);
        }
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['pagination'] = empty($request->pagination) ? false : (!empty($request->pagination) && $request->pagination == 'true' ? true : false);
        $data['packaging_materials'] = (new PackagingMaterial())::getPackagingMaterialsByFiltering($request->all(), $data['pagination'], $data['page_limit']);

        return response()->json([
            'status' => 200,
            'packaging_materials' => $data['packaging_materials']
        ], 200);
    }

    public function getLocations(Request $request)
    {
        if ($request->method() == 'POST') {
            return response()->json([
                'status' => 400,
                'message' => 'Method not allowed'
            ],400);
        }
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['pagination'] = empty($request->pagination) ? false : (!empty($request->pagination) && $request->pagination == 'true' ? true : false);
        $data['locations'] = (new Location())::getLocationsByFiltering($request->all(), $data['pagination'], $data['page_limit']);

        return response()->json([
            'status' => 200,
            'locations' => $data['locations']
        ], 200);
    }

    public function getVarieties(Request $request)
    {
        if ($request->method() == 'POST') {
            return response()->json([
                'status' => 400,
                'message' => 'Method not allowed'
            ],400);
        }
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['pagination'] = empty($request->pagination) ? false : (!empty($request->pagination) && $request->pagination == 'true' ? true : false);
        $data['varieties'] = (new Variety())::getVarietiesByFiltering($request->all(), $data['pagination'], $data['page_limit']);

        return response()->json([
            'status' => 200,
            'varieties' => $data['varieties']
        ], 200);
    }

    public function getActivityLogs(Request $request)
    {
        if ($request->method() == 'POST') {
            return response()->json([
                'status' => 400,
                'message' => 'Method not allowed'
            ],400);
        }
        $data['pagination'] = isset($request->pagination) ? true : false;
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['id'] = isset($request->id) ? $request->id : null;
        $data['user_id'] = isset($request->user_id) ? $request->user_id : null;
        $data['type'] = isset($request->type) ? $request->type : null;
        $data['logs'] = (new ActivityLog())::getActivityLogsByFiltering($data, $data['pagination'], $data['page_limit']);

        return response()->json([
            'status' => 200,
            'activity_logs' => $data['logs']
        ], 200);
    }
}
