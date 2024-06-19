<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Order;
use App\Models\Admin;
use App\Models\Setting;
use Hash;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data['user_count'] = User::count();
        $data['job_count'] = 0;
        $data['slot_count'] = 0;
        $data['order_count'] = Order::count();
        $data['users'] = User::where('status', 1)->orderBy('id', 'desc')->take('12')->get();
        $data['subscribers'] = [];
        $data['month'] = date('m');
        $data['month_year'] = date('Y');
        $data['month_dates'] = cal_days_in_month(CAL_GREGORIAN, $data['month'], $data['month_year']);

       
        return view('admin.dashboard.dashboard')->with($data);
    }


    public function updateGeneralSetting(Request $request)
    {
        $data['setting'] = request()->all();
        $updateSettings = Setting::pluck('setting_key')->toArray();
        foreach ($data['setting'] as $key => $value) {
            if (in_array($key, $updateSettings)) {
                Setting::where('setting_key', $key)->update(['setting_value' => $value]);
            } else {
                $settings = new Setting;
                $settings->setting_key    = $key;
                $settings->setting_value  = $value;
                $settings->save();
            }
        }
        return redirect()->back()->with('msg', 'Setting saved successfully');
    }

    public function setting()
    {
        $user_id = Auth::guard('admin')->id();
        $data['admin'] = Admin::where('id', $user_id)->first();

        $setting = Setting::get();
        $globalSetting = [];
        foreach ($setting as $key => $value) {
            $globalSetting[$value->setting_key] = $value->setting_value;
        }
        $data['globalSetting'] = $globalSetting;
        return view('admin.setting.setting')->with($data);
    }

    public function updateProfile(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $userId = Auth::guard('admin')->id();
        $user = Admin::find($userId);
        $user->uuid = Str::uuid($request->email);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->about = $request->about;
        $user->address = $request->address;
        $user->save();
        return redirect()->back()->with('msg', 'Profile updated successfully');
    }


    public function saveProfileImage(Request $request)
    {
        $userId = Auth::guard('admin')->id();
        $actionType = 'update';
        $uploadedFile = $request->file('file');
        $filename = rand(1111, 9999) . '_' . 'image.' . $uploadedFile->getClientOriginalExtension();
        $path = public_path('uploads/admin/');
        $upload_success = $uploadedFile->move($path, $filename);

        $user = Admin::find($userId);
        $user->image = $filename;
        $user->save();

        return response()->json(['success' => 'Profile image updated successfully.', 'actionType' => $actionType]);
    }


    public function saveProfileCoverImage(Request $request)
    {
        $userId = Auth::guard('admin')->id();
        $actionType = 'update';
        $uploadedFile = $request->file('file');
        $filename = rand(1111, 9999) . '_' . 'image.' . $uploadedFile->getClientOriginalExtension();
        $path = public_path('uploads/admin/');
        $upload_success = $uploadedFile->move($path, $filename);

        $user = Admin::find($userId);
        $user->cover_image = $filename;
        $user->save();

        return response()->json(['success' => 'Cover image updated successfully.', 'actionType' => $actionType]);
    }


    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        $admin_id =  Auth::guard('admin')->id();
        $admin = Admin::find($admin_id);
        $admin_password = $admin->password;

        if ($validator->passes()) {

            if (Hash::check($request->current_password, $admin_password)) {
                $admin->password = Hash::make($request->password);
                $admin->save();

                return response()->json(['success' => 'Password changed successfully.']);
            } else {
                return response()->json(['success' => 'Please enter valid Current Password.']);
            }
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('admin');
    }
}
