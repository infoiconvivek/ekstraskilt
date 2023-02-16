<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\UserProvided;
use App\Models\CovidVaccine;
use App\Models\UserDetail;
use App\Models\Slot;
use App\Models\TimeSheet;
use App\Models\Position;
use App\Models\Facility;
use App\Models\Device;
use App\Models\UserVerify;
use App\Models\Booking;

use Exception;
use File;
use Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if($request->position)
        {
            $data['users'] = User::select('users.*','user_details.*','users.id as uid')->leftJoin('user_details','user_details.user_id','users.id')->orderBy('users.id','desc')->where('user_details.position',$request->position)->paginate(15);
        } else if($request->facility)
        {
            $data['users'] = User::select('users.*','user_details.*','users.id as uid')->leftJoin('user_details','user_details.user_id','users.id')->orderBy('users.id','desc')->where('user_details.facility',$request->facility)->paginate(15);
        } else
        {
            $data['users'] = User::select('users.*','users.id as uid')->orderBy('id','desc')->paginate(15);
        }
        
        return view('admin.user.index')->with($data);
    }

    public function create(Request $request)
    {
        $data['categories'] = Category::orderBy('id','desc')->get();
        $data['provided'] = UserProvided::orderBy('id','desc')->get();
        $data['vaccines'] = CovidVaccine::orderBy('id','desc')->get();
        $data['positions'] = Position::orderBy('id','desc')->get();
        $data['facilities'] = Facility::orderBy('id','desc')->get();
        return view('admin.user.user-form')->with($data);
    }

    public function slots(Request $request)
    {
        $user_id = $request->id;
        $data['slots'] = Slot::where('user_id',$user_id)->orderBy('id','desc')->paginate(15);
        return view('admin.user.slot')->with($data);
    }


    public function timesheets(Request $request)
    {
        $user_id = $request->id;
        $data['timesheets'] = TimeSheet::where('user_id',$user_id)->orderBy('id','desc')->paginate(15);
        return view('admin.user.timesheet')->with($data);
    }


    public function save(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email',
            'status' => 'required'
        ]);

        if (!$request->user_id) {
            $user = new User();
            $msg = "User Added Successfully.";
        } else {
            $user = User::findOrFail($request->user_id);
            $msg = "User updated Successfully.";
        }
        try {
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            if (!$request->user_id) {
            $user->password = $request->password;
            }
            $user->uuid =  Str::uuid($request->email);
            $user->status = $request->status;
            $user->save();

            $detail = UserDetail::firstOrNew(['user_id' =>  $user->id]);
            $detail->user_id = $user->id;
            $detail->position = $request->position;
            $detail->facility = $request->facility;
            $detail->street_address = $request->street_address;
            $detail->apartment = $request->apartment;
            $detail->city = $request->city;
            $detail->prov = $request->prov;
            $detail->postal_code = $request->postal_code;
            $detail->dob = $request->dob;
            $detail->insurance_no = $request->insurance_no;
            $detail->career = $request->career;
            ///dd($request->user_provided);
            $detail->user_provided =  serialize($request->user_provided);
            $detail->covid_vaccines = serialize($request->covid_vaccines);
            $detail->save();


            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete', 'status']))
        return redirect()->back()->with(['message' => 'Invalid Action']);
        
        $user = User::findOrFail($id);

        if ($type == "edit") {
        $data['categories'] = Category::orderBy('id','desc')->get();
        $data['provided'] = UserProvided::orderBy('id','desc')->get();
        $data['vaccines'] = CovidVaccine::orderBy('id','desc')->get();
        $data['positions'] = Position::orderBy('id','desc')->get();
        $data['facilities'] = Facility::orderBy('id','desc')->get();
        $data['user'] = $user;
        $data['user_detail'] = UserDetail::where('user_id',$data['user']->id)->first();
            return view('admin.user.user-form')->with($data);
        }
        if ($type == "delete") {
            if (\File::exists(public_path($user->image))) {
                \File::delete(public_path($user->image));
            }
            $delUserDetail = UserDetail::where('user_id', $id)->delete();
            $delUserDevice = Device::where('user_id', $id)->delete();
            $delUserTimeSheet = TimeSheet::where('user_id', $id)->delete();
            $delUserVerify = UserVerify::where('user_id', $id)->delete();
            $delUserBooking = Booking::where('user_id', $id)->delete();
            $delUserSlot = Slot::where('user_id', $id)->delete();
            $delData = User::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $user->status = $user->status == 1 ? 0 : 1;
            $user->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
