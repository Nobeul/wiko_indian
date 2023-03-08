<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Verification;
use App\Models\Country;
use App\Models\ActivityLog;
use App\User;

class UserController extends Controller
{
    public function buyers(Request $request)
    {
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['order_by'] = isset($request->order_by) ? $request->order_by : '';
        $data['buyers'] = User::getUsersByFiltering(['user_type' => 2, 'order_by' => $data['order_by']], true, 
        $data['page_limit']);

        return response()->json([
            'status' => 200,
            'buyers' => $data['buyers']
        ], 200);
    }

    public function createNewBuyer(Request $request)
    {
        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:4',
                // 'email' => 'nullable|email|unique:users',
                'phone' => 'required|unique:users',
                // 'password' => 'required|min:6|confirmed',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:512',
                'country_id' => 'required',
                'user_type' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid data',
                    'errors' => $validator->errors()
                ], 400);
            }
            $new_buyer = (new User())->newUser($request->all());

            return response()->json([
                'status' => $new_buyer->getData()->status,
                'message' => $new_buyer->getData()->message
            ],$new_buyer->getData()->status);
        }

        return response()->json([
            'status' => 400,
            'message' => 'Method not allowed'
        ], 400);
    }

    public function editBuyer(Request $request)
    {
        $data['buyer'] = User::findById($request->id);
        if (empty($data['buyer'])) {
            return response()->json([
                'status' => 400,
                'message' => 'Buyer not found'
            ], 400);
        } else {
            if ($request->method() == 'POST') {
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'profile_image' => 'nullable|mimes:jpeg,png,jpg|max:512',
                    'partners' => 'nullable|array',
                    'exporting_countries' => 'nullable|array'
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Invalid data',
                        'errors' => $validator->errors()
                    ], 400);
                }

                $buyer = (new User())->updateUser($data['buyer'], $request->all());

                return response()->json([
                    'status' => $buyer->getData()->status,
                    'message' => $buyer->getData()->message
                ],$buyer->getData()->status);
            }

            if (count($data['buyer']->ratings) > 0) {
                $data['buyer']['rating'] = $data['buyer']->ratings->sum('rating') / count($data['buyer']->ratings);
            } else {
                $data['buyer']['rating'] = 0;
            }
            return response()->json([
                'status' => 200,
                'buyer' => $data['buyer']
            ], 200);
        }
    }

    public function deleteBuyer(Request $request)
    {
        if ($request->method() == 'GET') {
            return response()->json([
                'status' => 400,
                'message' => 'Method not allowed'
            ], 400);
        }
        $buyer = User::findById($request->id);

        if (empty($buyer)) {
            return response()->json([
                'status' => 400,
                'message' => 'Buyer not found'
            ], 400);
        }

        $verification = Verification::where(['user_id' => $buyer->id])->get()->toArray();
        if (!empty($verification)) {
            (new Verification())->destroy($verification);
        }
        $activity_log = ActivityLog::where('user_id', $buyer->id)->get();
        if (!empty($activity_log)) {
            foreach($activity_log as $log) {
                $log->delete();
            }
        }
        $buyer->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Buyer has been deleted successfully'
        ], 200);
    }

    public function sellers(Request $request)
    {
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['order_by'] = isset($request->order_by) ? $request->order_by : '';
        $data['sellers'] = User::getUsersByFiltering(['user_type' => 1, 'order_by' => $data['order_by']], true, $data['page_limit']);

        return response()->json([
            'status' => 200,
            'sellers' => $data['sellers']
        ], 200);
    }

    public function createNewSeller(Request $request)
    {
        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                // 'email' => 'required|email|unique:users',
                'phone' => 'required|unique:users',
                // 'password' => 'required|min:6|confirmed',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:512',
                'country_id' => 'required',
                'user_type' => 'required',
                'is_payment_verified' => 'boolean',
                'is_kyc_verified' => 'boolean',
                'in_business_since' => 'nullable|date',
                'partners' => 'nullable|array',
                'exporting_countries' => 'nullable|array'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid data',
                    'errors' => $validator->errors()
                ], 400);
            }
            $new_seller = (new User())->newUser($request->all());

            return response()->json([
                'status' => $new_seller->getData()->status,
                'message' => $new_seller->getData()->message
            ],$new_seller->getData()->status);
        }

        return response()->json([
            'status' => 400,
            'message' => 'Method not allowed'
        ], 400);
    }

    public function editSeller(Request $request)
    {
        $data['seller'] = User::findById($request->id);
        if (empty($data['seller'])) {
            return response()->json([
                'status' => 400,
                'message' => 'Seller not found'
            ], 400);
        } else {
            if ($request->method() == 'POST') {
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:512',
                    'partners' => 'nullable|array',
                    'exporting_countries' => 'nullable|array'
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Invalid data',
                        'errors' => $validator->errors()
                    ], 400);
                }

                $seller = (new User())->updateUser($data['seller'], $request->all());

                return response()->json([
                    'status' => $seller->getData()->status,
                    'message' => $seller->getData()->message
                ],$seller->getData()->status);
            }

            if (count($data['seller']->ratings) > 0) {
                $data['seller']['rating'] = $data['seller']->ratings->sum('rating') / count($data['seller']->ratings);
            } else {
                $data['seller']['rating'] = 0;
            }
            return response()->json([
                'status' => 200,
                'seller' => $data['seller']
            ], 200);
        }
    }

    public function deleteSeller(Request $request)
    {
        if ($request->method() == 'GET') {
            return response()->json([
                'status' => 400,
                'message' => 'Method not allowed'
            ], 400);
        }
        $seller = User::findById($request->id);

        if (empty($seller)) {
            return response()->json([
                'status' => 400,
                'message' => 'Seller not found'
            ], 400);
        }

        $verification = Verification::where(['user_id' => $seller->id])->get()->toArray();
        if (!empty($verification)) {
            (new Verification())->destroy($verification);
        }
        $activity_log = ActivityLog::where('user_id', $seller->id)->get();
        if (!empty($activity_log)) {
            foreach($activity_log as $log) {
                $log->delete();
            }
        }
        $seller->delete();
 
        return response()->json([
            'status' => 200,
            'message' => 'Seller has been deleted successfully'
        ], 200);
    }
}
