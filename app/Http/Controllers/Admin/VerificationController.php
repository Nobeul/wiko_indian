<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Verification;
use App\Models\VerificationType;
use App\User;

class VerificationController extends Controller
{
    public function index(Request $request)
    {
        $data['module'] = 'Verifications';
        $data['sub_module'] = 'List';
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['verification_type_id'] = !empty($request->verification_type_id) && is_numeric($request->verification_type_id) ? $request->verification_type_id : null;
        $data['user_id'] = !empty($request->user_id) && is_numeric($request->user_id) ? $request->user_id : null;
        if (!empty($request->status)) {
            if ($request->status == 'approved') {
                $data['status'] = 'approved';
            } else if ($request->status == 'pending') {
                $data['status'] = 'pending';
            } else if ($request->status == 'rejected') {
                $data['status'] = 'rejected';
            }
        }
        $data['verification_types'] = (new VerificationType())::all();
        $data['verifications'] = Verification::getVerificationsByFiltering($data, true, $data['page_limit']);
        $data['unique_users'] = Verification::with('user')->get()->unique('user_id');
        
        return view('admin.verifications.index', $data);
    }

    public function create(Request $request)
    {
        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'front_image' => 'required|image|mimes:jpeg,png,jpg|max:512',
                'back_image' => 'required|image|mimes:jpeg,png,jpg|max:512',
                'verification_type_id' => 'required|exists:verification_types,id',
                'verification_status' => 'required'
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }
    
            $new_verification = (new Verification())->newVerification($request->all());
            
            if ($new_verification->getData()->status == 200) {
                one_time_message('success', 'Verification added successfully');
                return redirect()->to('verifications');
            } else { 
                one_time_message('danger', $new_verification->getData()->message);
                return redirect()->back();
            }
        }

        $data['module'] = 'Verifications';
        $data['sub_module'] = 'Create';
        $data['users'] = User::where('user_type', '!=', 0)->get();
        $data['verification_types'] = (new VerificationType())::all();

        return view('admin.verifications.create', $data);
    }

    public function edit(Request $request)
    {
        $data['module'] = 'Verifications';
        $data['sub_module'] = 'Edit';
        $data['verification'] = $verification = Verification::where(['id' => $request->id])->first();

        if (empty($verification)) {
            return response()->json([
                'status' => 400,
                'message' => 'Verification data did not found'
            ], 400);
        }

        if ($request->method() == 'POST') {
            if (!($request->verification_status == 'pending' || $request->verification_status == 'approved' || $request->verification_status == 'rejected')) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Status can be either pending, rejected or approved'
                ], 400);
            }
            $validator = Validator::make($request->all(), [
                'verification_status' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $verification = (new Verification())->editVerification($verification, $request->all());

            if ($verification->getData()->status == 200) {
                one_time_message('success', 'Verification updated successfully');
                return redirect()->to('verifications');
            } else {
                one_time_message('danger', $verification->getData()->message);
                return redirect()->back();
            }
        }
        return view('admin.verifications.edit', $data);
    }
}
