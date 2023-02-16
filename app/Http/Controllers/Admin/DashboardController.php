<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Job;
use App\Models\Booking;
use App\Models\Slot;
use App\Models\TimeSlot;
use App\Models\Admin;
use App\Models\Setting;
use Hash;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data['user_count'] = User::count();
        $data['job_count'] = Job::count();
        $data['slot_count'] = TimeSlot::count();
        $data['booking_count'] = Booking::count();
        $data['users'] = User::where('status', 1)->orderBy('id', 'desc')->take('12')->get();
        $data['subscribers'] = [];
        $data['month'] = date('m');
        $data['month_year'] = date('Y');
        $data['month_dates'] = cal_days_in_month(CAL_GREGORIAN, $data['month'], $data['month_year']);

        $jobs = Job::whereNotIn('id', function($query){
            $query->select('job_id')
            ->from(with(new Booking)->getTable())
            ->where('status', 1);
        })->get()->toArray();

        ///dd($jobs);

        $job_array = [];
        foreach($jobs as $job)
        {
            $job['title'] = 'Job: '. $job['title'] . "\n" .' Time: '. $job['time_from']. ' - '.$job['time_to'];
           // dd($job['id']);
            unset($job['id']);
            unset($job['facility']);
            unset($job['position']);
            unset($job['location']);
            unset($job['time_from']);
            unset($job['time_to']);
            unset($job['descriptions']);
            unset($job['slug']);
            unset($job['status']);
            unset($job['created_at']);
            unset($job['updated_at']);
            $job['color'] = 'white';
            $job['backgroundColor'] = 'blue';
            $job_array[] = $job;
        }

    
        
        
        $booking = Booking::select('booking.id as booking_id','booking.*','jobs.title','jobs.time_from','jobs.time_to','jobs.id','users.id','users.first_name','users.last_name')->leftJoin('jobs','jobs.id','booking.job_id')->leftJoin('users','users.id','booking.user_id')->get()->toArray();
        $booking_array = [];
        foreach($booking as $book)
        {
            $book['date'] = date('Y-m-d', strtotime($book['created_at']));
            $book['title'] = 'Job: '. $book['title']. ',  User:'. $book['first_name']. ' '. $book['last_name']. "\n" . ' Time: '. $book['time_from']. ' - '.$book['time_to'];
            unset( $book['id']);
            unset( $book['booking_id']);
            unset( $book['user_id']);
            unset( $book['job_id']);
            unset( $book['status']);
            unset( $book['created_at']);
            unset( $book['updated_at']);
            //unset( $book->title);
            unset( $book['first_name']);
            unset( $book['last_name']);
            $book['color'] = 'white';
            $book['backgroundColor'] = 'green';
            $booking_array[] = $book;
        }
        //dd($booking);

        $data['events'] = array_merge_recursive($job_array,$booking_array);

        //dd($data['events']);
       
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
