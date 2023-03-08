<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\User;

class LoginController extends Controller
{
    public function register(Request $request)
    {
        if ($request->method() == 'GET') {
            return response()->json([
                'status' => 405,
                'message' => 'Method not allowed'
            ], 405);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'user_type' => 'required',
            'phone' => 'required|unique:users',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid data',
                'errors' => $validator->errors()
            ], 400);
        }

        $user = User::where('phone', request()->phone)->first();
        if (! empty($user)) {
            return response()->json([
                'status' => 400,
                'message' => 'Found a registered user with provided phone number. You can instead login'
            ], 400);
        }
        
        
        $user = (new User())->newUser($request->all());
        if ($user->getData()->status == 200) {
            return response()->json([
                'status' => 200,
                'message' => 'Registration was successfull',
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => $user->getData()->message
            ], 400);
        }
    }

    public function login(Request $request)
    {
        if ($request->method() == 'GET') {
            return response()->json([
                'status' => 405,
                'message' => 'Method not allowed'
            ], 405);
        }
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required',
                'otp' => 'required|min:6'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid data',
                    'errors' => $validator->errors()
                ], 400);
            }
            if (! $request->otp == '123456') {
                return response()->json([
                    'status' => 400,
                    'message' => 'OTP did not match.'
                ], 200);
            }


            $user = User::where('phone', $request->phone)->first();
            if (empty($user)) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Phone number is incorrect'
                ], 400);
            }

            if (Auth::loginUsingId($user->id)) {
                $log                  = [];
                $log['user_id']       = Auth::check() ? Auth::user()->id : null;
                if (Auth::check()) {
                    if (Auth::user()->user_type == 0) {
                        $log['type'] = 'Admin';
                    } else if (Auth::user()->user_type == 1) {
                        $log['type'] = 'Seller';
                    } else {
                        $log['type'] = 'Buyer';
                    }
                } else {
                    $log['type'] = 'Unknown';
                }
                $log['ip_address']    = $request->ip();
                $log['browser_agent'] = $request->header('user-agent');
                ActivityLog::create($log);
                $user = Auth::user();
                $access_token = $user->createToken('accessToken')->accessToken;

                return response()->json([
                    'status' => 200,
                    'message' => 'Successfully Logged in',
                    'data' => $user,
                    'access_token' => $access_token
                ], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Unauthenticated. Credentials did not match'
                ], 400);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' => $th
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        if ($request->method() == 'GET') {
            return response()->json([
                'status' => 405,
                'message' => 'Method not allowed'
            ], 405);
        }
        Auth::user()->token()->revoke();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully logged out'
        ], 200);
    }

    public function generateOtp()
    {
        if (request()->method() == 'POST') {
            return response()->json([
                'status' => 405,
                'message' => 'Method not allowed'
            ], 405);
        }
        $validator = Validator::make(request()->all(), [
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid data',
                'errors' => $validator->errors()
            ], 400);
        }

        $user = User::where('phone', request()->phone)->first();
        if (empty($user)) {
            return response()->json([
                'status' => 400,
                'message' => 'No such registered user found with provided phone number'
            ], 400);
        }
        return response()->json([
            'status' => 200,
            'otp' => '123456'
        ], 200);
    }
}
