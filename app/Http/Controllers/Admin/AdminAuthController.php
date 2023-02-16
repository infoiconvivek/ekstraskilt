<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\ResetAdminPasswordMail;
use App\Models\Admin;
use App\Models\User;
use File;
use DB;
use Mail;



class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        return view('admin.auth.login');
    }

    public function authenticate(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);
        $email = $request->email;
        $password = ($request->password);

        if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $password, 'status' => 1])) {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }

        return redirect()->back()->with('msg', 'Please enter valid Email Id Or Password');
    }


    public function forgotPassword(Request $request)
    {
        return view('admin.auth.forgot-password');
    }

    public function resetPasswordEmail(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|max:255'
        ]);

        $countAdmin = Admin::where('email',$request->email)->count();
        if ($countAdmin < 1) {
            return redirect()->back()->with('msg', 'User does not exist');
        }
        $token = Str::random(64);
       
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

         $arr = [
            'email' => $request->email,
            'token' => $token,
         ];
        Mail::to($request->email)->send(new ResetAdminPasswordMail($arr));

        return back()->with('msg', 'We have e-mailed your password reset link!');


    }

    public function resetPassword(Request $request)
    {
        if(empty($request->token))
        {
            return redirect('admin/login');
        }
        return view('admin.admin.reset-password');
    }

    public function updateAdminPassword(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
                              ->where([
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
              return back()->with('msg', 'Invalid token!');
          }

          $user = Admin::where('email', $updatePassword->email)
          ->update(['password' => bcrypt($request->password)]);
         ///dd($updatePassword->email);
         DB::table('password_resets')->where(['email'=> $updatePassword->email])->delete();

        return back()->with('msg', 'Your password has been changed!');
    }

    
}
