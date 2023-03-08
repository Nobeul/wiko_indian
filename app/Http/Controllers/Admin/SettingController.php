<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\User;
use DB;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $data['module'] = 'Settings';
        $data['sub_module'] = 'Company Settings';
        $data['company_settings'] = (new Setting())::first();
        
        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(), [
                'company_name' => 'required',
                'company_image' => 'nullable|image|mimes:jpeg,png,jpg|max:512'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            (new Setting())->companySettings($request->all());

            one_time_message('success', 'Company settings has been updated successfully');
            return redirect()->to('company-settings');
        }

        return view('admin.settings.index', $data);
    }

    public function forgetPassword(Request $request)
    {
        if ($request->method() == 'POST') {
            $user  = User::where('email', $request->email)->first();
            if (!$user)
            {
                one_time_message('danger', __('Email Address does not match!'));
                return back();
            }

            $userData['email']      = $request->email;
            $userData['token']      = $token      = base64_encode(encryptIt(rand(1000000, 9999999) . '_' . $request->email));
            $userData['created_at'] = date('Y-m-d H:i:s');

            DB::table('password_resets')->insert($userData);

            $this->sendPasswordResetEmail($request->email, $token, $user->name); //email

            one_time_message('success', __('Password reset link has been sent to your email address'));
            return back();
        }

        return view('auth.passwords.email');
    }

    public function sendPasswordResetEmail($toEmail, $token, $userFullName)
    {
        $company_name = !empty(companyName()) ? companyName() : config('app.name', 'Laravel');
        $data['user_name'] = $userFullName;
        $data['email'] = $toEmail;
        $data['password_reset_url'] = url('password/resets', $token);
        $data['company_name'] = $company_name;
        $subject = 'Notice for Password Reset!';
        $message = view('email_template.reset_password', $data)->render();

        (new Setting())->setupEmailConfig();

        (new Setting())->sendEmail($toEmail, $subject, $message);
    }

    public function verifyToken($token)
    {
        if (!$token)
        {
            one_time_message('error', 'Token not found!');
            return back();
        }
        $reset = DB::table('password_resets')->where('token', $token)->first();
        if ($reset)
        {
            $data['token'] = $token;
            return view('auth.passwords.reset', $data);
        }
        else
        {
            one_time_message('error', __('Token session has been destroyed. Please try to reset again.'));
            return back();
        }
    }

    public function confirmNewPassword(Request $request)
    {
        $token    = $request->token;
        $password = $request->password;
        $confirm = DB::table('password_resets')->where('token', $token)->first();
        $user           = User::where('email', $confirm->email)->first();
        $user->password = Hash::make($password);
        $user->save();
        DB::table('password_resets')->where('token', $token)->delete();

        one_time_message('success', __('Password changed successfully.'));
        return redirect()->to('/login');
    }
}
