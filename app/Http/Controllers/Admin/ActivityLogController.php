<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $data['module'] = 'Activity Logs';
        $data['sub_module'] = 'List';
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['id'] = isset($request->id) ? $request->id : null;
        $data['user_id'] = isset($request->user_id) ? $request->user_id : null;
        $data['user_type'] = isset($request->user_type) ? $request->user_type : null;
        $data['logs'] = (new ActivityLog())::getActivityLogsByFiltering($data, true, $data['page_limit']);

        return view('admin.activity_logs.index', $data);
    }
}
