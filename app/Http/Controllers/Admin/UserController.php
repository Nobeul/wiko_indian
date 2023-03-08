<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\Verification;
use App\Models\Country;
use App\User;

class UserController extends Controller
{
    public function buyers(Request $request)
    {
        $data['module'] = 'Users';
        $data['sub_module'] = 'Buyers';
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['name'] = isset($request->name) ? $request->name : null;
        $data['phone'] = isset($request->phone) ? $request->phone : null;
        $data['buyers'] = User::getUsersByFiltering(['user_type' => 2, 'with' => ['country', 'verifications'], 'name' => $data['name'], 'phone' => $data['phone'], 'order_by' => 'id'], true, 
        $data['page_limit']);

        return view('admin.users.buyers', $data);
    }

    public function createNewBuyer(Request $request)
    {
        $data['module'] = 'Users';
        $data['sub_module'] = 'Create New Buyers';

        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:4',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:512',
                'country_id' => 'required',
                'user_type' => 'required',
                'phone' => 'required|unique:users'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            (new User())->newUser($request->all());

            one_time_message('success', 'A new buyer created');
            return redirect()->to('buyers');
        }

        $data['countries'] = (new Country())::all();

        return view('admin.users.create_buyers', $data);
    }

    public function editBuyer(Request $request)
    {
        $data['module'] = 'Users';
        $data['sub_module'] = 'Edit Buyers';
        $data['buyer'] = User::findById($request->id);
        if (empty($data['buyer'])) {
            one_time_message('danger', 'Buyer not found');
            return redirect()->back();
        } else {
            if ($request->method() == 'POST') {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|min:4',
                    'password' => 'nullable|min:6|confirmed',
                    'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:512',
                    'phone' => 'required|unique:users,phone,'.$request->id
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator);
                }

                (new User())->updateUser($data['buyer'], $request->all());

                one_time_message('success', 'Buyer info updated successfully');
                return redirect()->to('buyers');
            }

            $data['countries'] = (new Country())::all();

            return view('admin.users.edit_buyers', $data);
        }
    }

    public function deleteBuyer(Request $request)
    {
        $buyer = User::findById($request->id);

        if (empty($buyer)) {
            one_time_message('danger', 'Buyer not found');
            return redirect()->to('/buyers');
        } else {
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

            one_time_message('success', 'Buyer deleted successfully');
            return redirect()->to('/buyers');
        }
    }

    public function sellers(Request $request)
    {
        $data['module'] = 'Users';
        $data['sub_module'] = 'Sellers';
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $data['name'] = isset($request->name) ? $request->name : null;
        $data['phone'] = isset($request->phone) ? $request->phone : null;
        $data['sellers'] = User::getUsersByFiltering(['user_type' => 1, 'with' => 'country', 'name' => $data['name'], 'phone' => $data['phone'], 'order_by' => 'id'], true, $data['page_limit']);

        return view('admin.users.sellers', $data);
    }

    public function createNewSeller(Request $request)
    {
        $data['module'] = 'Users';
        $data['sub_module'] = 'Create New Sellers';

        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:4',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:512',
                'country_id' => 'required',
                'user_type' => 'required',
                'phone' => 'required|unique:users'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            (new User())->newUser($request->all());

            one_time_message('success', 'A new seller created');
            return redirect()->to('sellers');
        }

        $data['countries'] = (new Country())::all();

        return view('admin.users.create_sellers', $data);
    }

    public function editSeller(Request $request)
    {
        $data['module'] = 'Users';
        $data['sub_module'] = 'Edit Sellers';
        $data['seller'] = User::findById($request->id);
        if (empty($data['seller'])) {
            one_time_message('danger', 'Seller not found');
            return redirect()->back();
        } else {
            if ($request->method() == 'POST') {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|min:4',
                    'password' => 'nullable|min:6|confirmed',
                    'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:512',
                    'phone' => 'required|unique:users,phone,'.$request->id
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator);
                }

                (new User())->updateUser($data['seller'], $request->all());

                one_time_message('success', 'Seller info updated successfully');
                return redirect()->to('sellers');
            }

            $data['countries'] = (new Country())::all();

            return view('admin.users.edit_sellers', $data);
        }
    }

    public function deleteSeller(Request $request)
    {
        $seller = User::findById($request->id);

        if (empty($seller)) {
            one_time_message('danger', 'Seller not found');
            return redirect()->to('/sellers');
        } else {
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

            one_time_message('success', 'Seller deleted successfully');
            return redirect()->to('/sellers');
        }
    }

    public function profile(Request $request)
    {
        $data['module'] = 'User';
        $data['sub_module'] = 'Profile';
        $data['seller'] = Auth::user();

        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:4',
                'password' => 'nullable|min:6|confirmed',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:512'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            (new User())->updateUser($data['seller'], $request->all());

            one_time_message('success', 'Profile info updated successfully');
            return redirect()->back();
        }

        $data['countries'] = (new Country())::all();

        return view('admin.users.profile', $data);
    }
}
