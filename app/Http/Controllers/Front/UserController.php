<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderAddress;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Mail\ResetUserPasswordMail;
use Carbon\Carbon;
use Exception;
use DB;
use Mail;

class UserController extends Controller
{


  public function login()
  {
    return view('front.login');
  }

  public function forgotPassword()
  {
    return view('front.forgot-password');
  }

  public function register()
  {
    $data['countries'] = Country::orderBy('name', 'asc')->get();
    return view('front.register')->with($data);
  }




  public function sendResetPassLink(Request $request)
  {
    $validatedData = $request->validate([
      'email' => 'required|email|max:255'
    ]);

    $countUser = User::where('email', $request->email)->where('status', 1)->count();

    if ($countUser < 1) {
      return redirect()->back()->with('msg', 'User does not exist');
    }

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

    return back()->with('msg', 'If this email address has been registered in our shop, you will receive a link to reset your password at gaurav@yopmail.com.');
  }


  public function resetPassword(Request $request)
  {
    if (empty($request->pswtoken)) {
      return redirect('/');
    }
    return view('front.reset-password');
  }


  public function updateUserEmailPassword(Request $request)
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

    if (!$updatePassword) {
      return back()->with('msg', 'Invalid token!');
    }

    $user = User::where('email', $updatePassword->email)
      ->update(['password' => bcrypt($request->password)]);
    ///dd($updatePassword->email);
    DB::table('password_resets')->where(['email' => $updatePassword->email])->delete();

    return redirect('login')->with('msg', 'Your password has been reset successfully !');
  }


  public function myaccount()
  {
    $data['orders'] = Order::where('user_id', 1)->orderBy('id', 'desc')->get();
    return view('user.myaccount')->with($data);
  }


  public function orders()
  {
    $data['orders'] = Order::where('user_id', 1)->orderBy('id', 'desc')->get();
    return view('user.orders')->with($data);
  }

  public function orderDetails($order_id)
  {
    $data['items'] = OrderItem::where(['order_id' => $order_id, 'user_id' => Auth::user()->id])->orderBy('id', 'desc')->get();
    $data['address'] = OrderAddress::where(['order_id' => $order_id, 'user_id' => Auth::user()->id])->orderBy('id', 'desc')->first();
    return view('user.order-details')->with($data);
  }

  public function myProfile()
  {
    $user_id = Auth::user()->id;
    $data['countries'] = Country::orderBy('name', 'asc')->get();
    $data['user'] = User::where('id', $user_id)->first();
    $data['details'] = UserDetail::where('user_id', $user_id)->first();
    return view('user.my-profile')->with($data);
  }

  public function changePassword()
  {
    return view('user.change-password');
  }



  public function logout(Request $request)
  {
    Auth::logout();
    return redirect('/');
  }

  public function userAuth(Request $request, $type)
  {
    if ($type != "login" && $type != "register") {
      return abort(404);
    }


    if ($type == "login") {

      $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Authentication passed...
        return response()->json(['logMessage' => 'Login successful' , 'status'=>1], 200);
    } else {
        return response()->json(['logMessage' => 'Invalid credentials' , 'status'=>0], 200);
    }

    }


    if ($type == "register") {

      $jsonData = $request->json()->all();
      
      $validatedData = $request->validate([
        'user_email' => 'required|string|email|max:255',
        'user_password' => 'required|string|min:6',
    ]);

    $user = User::firstOrNew(['email' =>  $request->user_email]);
    $user->email = $request->user_email;
    $user->password = bcrypt($request->user_password);
    $user->uuid =  Str::uuid($request->user_email);
    $user->status = 1;
    $user->save();

    $user_detail = new UserDetail();
    $user_detail->user_id = $user->id;
    $user_detail->save();
    

    return response()->json(['regMessage' => 'En lenke for å angi et nytt passord vil bli sendt til e-postadressen din.'], 200);
    }


    return redirect('/');
  }


  public function updateUserPassword(Request $request)
  {
    $validatedData = $request->validate([
      'current_password' => 'required',
      'password' => 'required|min:6',
      'password_confirmation' => 'required|same:password',
    ]);
    $user_password = Auth::User()->password;

    if (Hash::check($request->current_password, $user_password)) {
      $user_id = Auth::user()->id;
      $obj_user = User::find($user_id);
      $obj_user->password = Hash::make($request->password);
      $obj_user->save();
      return redirect()->back()->with('msg', 'Password changes successfully.');
    } else {
      return redirect()->back()->with('msg', 'Please enter valid Current Password.');
    }
  }


  public function updateProfile(Request $request)
  {
    $this->validate($request, [
      'email' => 'required',
      'first_name' => 'required',
      'last_name' => 'required',
      'phone' => 'required',
      'address' => 'required',
      'city' => 'required',
      'zip_code' => 'required',
    ]);

    $user_id = Auth::user()->id;

    $user = User::firstOrNew(['id' =>  $user_id]);
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->phone = $request->phone;
    $user->status = 1;
    $user->save();

    $details  = UserDetail::firstOrNew(['user_id' =>  $user_id]);
    $details->address = $request->address;
    $details->city = $request->city;
    $details->zip_code = $request->zip_code;
    $details->save();


    return redirect()->back()->with('msg', 'Profile updated successfully.');
  }
}
