<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Mail\ResetUserPasswordMail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserVerify;
use App\Models\UserDetail;
use App\Models\Category;
use App\Models\CovidVaccine;
use App\Models\UserProvided;
use App\Models\Setting;
use App\Models\Position;
use App\Models\Device;
use Mail;
use DB;

class UserController extends Controller
{
    
     public function signup(Request $request)
    {


          ///dd($request->user_provided);

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return response(['message' => $validator->errors()->first(), 'success' => false,], 422);
        }

        $token = Str::random(64);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->uuid =  Str::uuid($request->email);
        $user->status = 1;

        if ($request->verified) {
            $user->email_verified_at =  date('Y-m-d H:i:s');
            $user->is_email_verified = 1;
        }
        $user->save();

            $detail = UserDetail::firstOrNew(['user_id' =>  $user->id]);
            $detail->user_id = $user->id;
            $detail->position = $request->position;
            $detail->street_address = $request->street_address;
            $detail->apartment = $request->apartment;
            $detail->city = $request->city;
            $detail->prov = $request->prov;
            $detail->postal_code = $request->postal_code;
            $detail->dob = $request->dob;
            $detail->insurance_no = $request->insurance_no;
            $detail->career = $request->career;
           
            $detail->user_provided =  serialize($request->user_provided);
            $detail->covid_vaccines = serialize($request->covid_vaccines);

            // $detail->user_provided =  serialize([]);
            // $detail->covid_vaccines = serialize([]);

            $detail->save();

            Device::where(['token' => $request->device_token, 'type' => $request->device_type])->delete();
            // if (!$device) {
            //$device = Device::firstOrNew(['token' => $request->device_token, 'type' => $request->device_type]);
            $device = new Device();
            $device->user_id = $user->id;
            $device->token = $request->device_token;
            $device->type = $request->device_type;
            $device->save();
            // }
            $user->details = UserDetail::where('user_id', $user->id)->first();
            $user->details->user_provided =  unserialize($user->details->user_provided ?? '');
            $user->details->covid_vaccines = unserialize($user->details->covid_vaccines ?? '');

        if ($request->verified) {
            UserVerify::where('user_id', $request->email)->delete();
        } else {
            $userVerify = new UserVerify();
            $userVerify->user_id = $user->id;
            $userVerify->token = $token;
            $userVerify->save();

            Mail::send('emails.user-email-verification', ['token' => $token, 'email' => $request->email], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Email Verification Mail');
            });
        }

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json([
            'success' => true,
            'message' => 'Register successfully',
            'user' => $user,
            'token_type' => 'Bearer',
            'token' => $token

        ]);
    }


    public function userVerify(Request $request)
    {
        return view('user.user-verify');
    }


    public function accountVerify(Request $request)
    {
        $token = $request->token;
        $userCount = UserVerify::where('token', $token)->count();
        if ($userCount < 1) {
            $msg = 'Sorry your email cannot be identified.';
        }
        $verifyUser = UserVerify::where('token', $token)->first();
        if (!is_null($verifyUser)) {
            $user = $verifyUser->user;

            if(!$user->is_email_verified) {
            $verifyUser->user->email_verified_at = Carbon::now();
            $verifyUser->user->is_email_verified = 1;
            $verifyUser->user->save();
            $msg = 'Your e-mail is verified. You can now login.';
            } else
            {
            $msg = 'Your e-mail is already verified. You can now login.';
            }
            return redirect('user/user-verify')->with('msg', $msg);

        }
    }



    public function register(Request $request)
    {


          ///dd($request->user_provided);

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return response(['message' => $validator->errors()->first(), 'success' => false,], 422);
        }

        $token = Str::random(64);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->uuid =  Str::uuid($request->email);
        $user->status = 1;

        if ($request->verified) {
            $user->email_verified_at =  date('Y-m-d H:i:s');
            $user->is_email_verified = 1;
        }
        $user->save();

            $detail = UserDetail::firstOrNew(['user_id' =>  $user->id]);
            $detail->user_id = $user->id;
            $detail->position = $request->position;
            $detail->street_address = $request->street_address;
            $detail->apartment = $request->apartment;
            $detail->city = $request->city;
            $detail->prov = $request->prov;
            $detail->postal_code = $request->postal_code;
            $detail->dob = $request->dob;
            $detail->insurance_no = $request->insurance_no;
            $detail->career = $request->career;
           
          
            $detail->user_provided =  serialize($request->user_provided);
            $detail->covid_vaccines = serialize($request->covid_vaccines);

            // $detail->user_provided =  serialize([]);
            // $detail->covid_vaccines = serialize([]);

            $detail->save();


            $user->details->user_provided =  unserialize($user->details->user_provided ?? '');
            $user->details->covid_vaccines = unserialize($user->details->covid_vaccines ?? '');

            Device::where(['token' => $request->device_token, 'type' => $request->device_type])->delete();
            // if (!$device) {
            //$device = Device::firstOrNew(['token' => $request->device_token, 'type' => $request->device_type]);
            $device = new Device();
            $device->user_id = $user->id;
            $device->token = $request->device_token;
            $device->type = $request->device_type;
            $device->save();
            // }

        if ($request->verified) {
            UserVerify::where('user_id', $request->email)->delete();
        } else {
            $userVerify = new UserVerify();
            $userVerify->user_id = $user->id;
            $userVerify->token = $token;
            $userVerify->save();

            Mail::send('emails.user-email-verification', ['token' => $token, 'email' => $request->email], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Email Verification Mail');
            });
        }

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json([
            'success' => true,
            'message' => 'Register successfully',
            'user' => $user,
            'token_type' => 'Bearer',
            'token' => $token

        ]);
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['message' => $validator->errors()->first(),'success' => false,], 422);
        }

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $userData = User::where('email', $request->email)->first();
            $userData->details = UserDetail::where('user_id', $userData->id)->first();

            if($userData->details)
            {
            $userData->details->user_provided =  unserialize($userData->details->user_provided ?? '');
            $userData->details->covid_vaccines = unserialize($userData->details->covid_vaccines ?? '');
            }

            $deleteUserCount = User::where('email', $request->email)->where('deleted_at', '!=', '')->count();
            if ($deleteUserCount == 1) {
                $response = ['success' => true, 'error' => 'Account deactivated', 'user' => $userData];
                return response()->json($response, 200);
            }

            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;

            Device::where(['token' => $request->device_token, 'type' => $request->device_type])->delete();
            // if (!$device) {
            //$device = Device::firstOrNew(['token' => $request->device_token, 'type' => $request->device_type]);
            $device = new Device();
            $device->user_id = $userData->id;
            $device->token = $request->device_token;
            $device->type = $request->device_type;
            $device->save();
            // }

           
            $response = ['success' => true, 'message' => 'Login successfully', 'user' => $userData, 'token_type' => 'Bearer', 'token' => $token];
            return response()->json($response, 200);
        } else {
            $response = ['success' => false, 'message' => 'Invalid email or password', 'user' => '', 'token_type' => 'Bearer', 'token' => ''];
            return response()->json($response, 422);
        }
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $countUser = User::where('email', $request->email)->where('status', 1)->count();
        if ($countUser < 1) {
            $response = ['success' => false, 'message' => 'User does not exist'];
            return response()->json($response, 200);
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
        Mail::to($request->email)->send(new ResetUserPasswordMail($arr));

        $response = ['success' => true, 'message' => 'We have e-mailed your password reset link'];
        return response()->json($response, 200);
    }


    public function resetPassword(Request $request)
    {
        
        if(empty($request->pswtoken))
        {
            dd('Invalid Request');
        }
        return view('user.reset-password');
    }

    public function updateUserPassword(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
                              ->where([
                                'token' => $request->pswtoken
                              ])
                              ->first();

                              ///dd($request->pswtoken);
  
          if(!$updatePassword){
              return back()->with('msg', 'Invalid token!');
          }

          $user = User::where('email', $updatePassword->email)
          ->update(['password' => bcrypt($request->password)]);
         ///dd($updatePassword->email);
         DB::table('password_resets')->where(['email'=> $updatePassword->email])->delete();
         $msg = 'Your password has been changed!.';
         return redirect('user/user-verify')->with('msg', $msg);
    }


    public function createAuth(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors()->first()], 422);
        }

        $userCount = User::where('email', $request->email)->count();
        if ($userCount == 0) {
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->status = 1;
            $user->email_verified_at =  date('Y-m-d H:i:s');
            $user->is_email_verified = 1;
            $user->save();

            $userDetail = new UserDetail();
            $userDetail->user_id = $user->id;
            $userDetail->save();

         
            $token = $user->createToken('LaravelAuthApp')->accessToken;
        } else {
            $user = User::where('email', $request->email)->first();
            $user->save();
            $token = $user->createToken('LaravelAuthApp')->accessToken;
        }

        $userDetail = UserDetail::where('id', $user->id)->first();
        
        return response()->json([
            'success' => true,
            'message' => 'Auth created successfully',
            'user' => $user,
            'token_type' => 'Bearer',
            'token' => $token

        ]);
    }

    


    public function getUser(Request $request)
    {
        $user_id = Auth::guard('api')->user()->id;
        $user = User::where('id', $user_id)->first();
        // unset($user->user_provided);
        // unset($user->covid_vaccines);
        $user->details = UserDetail::where('user_id', $user_id)->first();

        $user->details->user_provided =  unserialize($user->details->user_provided);
        $user->details->covid_vaccines = unserialize($user->details->covid_vaccines);
       

        $response = [
            'success' => true,
            'message' => 'User Detail',
            'user' => $user,
        ];

        return response()->json($response, 200);
    }




    public function updateUserProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $user_id = auth('api')->user()->id;
        
        $user = User::firstOrNew(['id' =>  $user_id]);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;

        $detail = UserDetail::firstOrNew(['user_id' =>  $user_id]);

            $detail->position = $request->position;
            $detail->street_address = $request->street_address;
            $detail->apartment = $request->apartment;
            $detail->city = $request->city;
            $detail->prov = $request->prov;
            $detail->postal_code = $request->postal_code;
            $detail->dob = $request->dob;
            $detail->insurance_no = $request->insurance_no;
            $detail->career = $request->career;
            $detail->user_provided =  serialize($request->user_provided);
            $detail->covid_vaccines = serialize($request->covid_vaccines);
            $detail->save();

            $user->details = UserDetail::where('user_id', $user_id)->first();
            $user->details->user_provided =  unserialize($user->details->user_provided ?? '');
            $user->details->covid_vaccines = unserialize($user->details->covid_vaccines ?? '');


        $response = [
            'success' => true,
            'message' => 'Profile updated successfully',
            'user' => $user,
        ];

        return response()->json($response, 200);
    }




    function changePassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'new_password' => 'required',
            'old_password' => 'required'
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $data = $request->all();
        $user = Auth::guard('api')->user();
        if (isset($data['old_password']) && !empty($data['old_password']) && $data['old_password'] !== "" && $data['old_password'] !== 'undefined') {
            $check  = Auth::guard('web')->attempt([
                'email' => $user->email,
                'password' => $data['old_password']
            ]);

            if ($check && isset($data['new_password']) && !empty($data['new_password']) && $data['new_password'] !== "" && $data['new_password'] !== 'undefined') {
                $user->password = bcrypt($data['new_password']);
                $user->token()->revoke();
                $token = $user->createToken('newToken')->accessToken;
                $user->save();
                $response = ['success' => true, 'message' => 'password changed successfully', 'user' => $user, 'token_type' => 'Bearer', 'token' => $token];
            } else {
                $response = ['success' => false, 'message' => 'Invalid password.', 'user' => $user];
            }
        }
        return response()->json($response, 200);
    }


    public function getCovidVaccine(Request $request)
    {
        $data = CovidVaccine::where(['status' => 1])->get();
        $response = ['data' => $data, 'message' => "Covid Vaccine List", 'success' => true];
        return response()->json($response, 200);
    }


    public function getCategory(Request $request)
    {
        $data = Category::where(['status' => 1])->get();
        $response = ['data' => $data, 'message' => "Category List", 'success' => true];
        return response()->json($response, 200);
    }


    public function getPosition(Request $request)
    {
        $data = Position::where(['status' => 1])->get();
        $response = ['data' => $data, 'message' => "Position List", 'success' => true];
        return response()->json($response, 200);
    }


    public function getUmsProvided(Request $request)
    {
        $data = UserProvided::where(['status' => 1])->get();
        $response = ['data' => $data, 'message' => "UMS Provided List", 'success' => true];
        return response()->json($response, 200);
    }



    public function about(Request $request)
    {
        $data = Page::where(['status' => 1, 'id' => 1])->first();
        $response = ['title' => $data->title, 'descriptions' => $data->descriptions, 'success' => true];
        return response()->json($response, 200);
    }

    public function privacyPolicy(Request $request)
    {
        $data = Page::where(['status' => 1, 'id' => 2])->first();
        $response = ['title' => $data->title, 'descriptions' => $data->descriptions, 'success' => true];
        return response()->json($response, 200);
    }


    public function termsConditions(Request $request)
    {
        $data = Page::where(['status' => 1, 'id' => 3])->first();
        $response = ['title' => $data->title, 'descriptions' => $data->descriptions, 'success' => true];
        return response()->json($response, 200);
    }

    public function logout(Request $request)
    {
        $user = auth('api')->user()->token();
        $user->revoke();
        $response = ['message' => 'Logout successfully', 'success' => true];
        return response()->json($response, 200);
    }

    public function getSetting(Request $request)
    {
        $setting = Setting::all();
        $response = ['data' => $setting, 'success' => true];
        return response()->json($response, 200);
    }
    

    // shubham web api react app

    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()->first()], 422);
        }

        $token = rand(100000, 999999);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json(['success' => true], 201);
        } else {
            $verify = UserVerify::where('user_id', $request->email)->first();
            if ($verify) {
                $verify->token = $token;
            } else {
                $verify = new UserVerify();
                $verify->user_id = $request->email;
                $verify->token = $token;
            }
            $verify->save();
            Mail::send('emails.user-email-otp', ['token' => $token, 'email' => $request->email], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Email OTP Mail');
            });

            return response()->json(['success' => true], 200);
        }
    }

    public function checkOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|min:6|max:6'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()->first()], 422);
        }

        $verify = UserVerify::where(['user_id' => $request->email, 'token' => $request->otp])->first();


        if ($verify) {
            return response()->json(['success' => true], 201);
        } else {
            return response(['error' => 'The entered code is invalid.'], 422);
        }
    }

    









   



        

}
