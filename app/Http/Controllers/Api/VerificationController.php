<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Verification;
use App\Models\VerificationType;

class VerificationController extends Controller
{
    public function create(Request $request)
    {
        if ($request->method() == 'GET') {
            return response()->json([
                'status' => 405,
                'message' => 'Method not allowed'
            ], 405);
        }
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'front_image' => 'required|image|mimes:jpeg,png,jpg|max:512',
            'back_image' => 'required|image|mimes:jpeg,png,jpg|max:512',
            'verification_type_id' => 'required|exists:verification_types,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid data',
                'errors' => $validator->errors()
            ], 400);
        }

        $new_verification = (new Verification())->newVerification($request->all());
        
        $response = [
            'status' => $new_verification->getData()->status,
            'message' => $new_verification->getData()->message
        ];
        if (isset($new_verification->getData()->_verification_message)) {
            $response['verification_status'] = $new_verification->getData()->_verification_message;
        }
        return response()->json($response, $new_verification->getData()->status);
    }

    public function verificationTypes()
    {
        if (request()->method() == 'POST') {
            return response()->json([
                'status' => 405,
                'message' => 'Method not allowed'
            ], 405);
        }
        $types = VerificationType::all();
        return response()->json([
            'status' => 200,
            'verification_types' => $types
        ], 200);
    }
}
