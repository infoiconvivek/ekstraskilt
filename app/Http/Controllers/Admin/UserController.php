<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\UserDetail;
use App\Models\Device;
use App\Models\UserVerify;
use App\Models\Booking;

use Exception;
use File;
use Hash;

class UserController extends Controller
{
    public function index()
    {
        $data['users'] = User::select('users.*','users.id as uid')->orderBy('id','desc')->paginate(15);
        
        return view('admin.user.index')->with($data);
    }

 

    public function create(Request $request)
    {
        $data['categories'] = Category::orderBy('id','desc')->get();
        return view('admin.user.user-form')->with($data);
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
            $user->user_type = 2;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->view_password = $request->password;

            if ($request->hasFile('image')) {
                $name = $request->image->getClientOriginalName();
                $filename =  date('ymdgis') . $name;
                $request->image->move(public_path() . '/storage/user/', $filename);
                $user->image = '/storage/user/' . $filename;
            }

            $user->phone = $request->phone;
            $user->uuid =  Str::uuid($request->email);
            $user->status = $request->status;
            $user->save();

            $detail = UserDetail::firstOrNew(['user_id' =>  $user->id]);
            $detail->user_id = $user->id;
            $detail->street_address = $request->street_address;
            $detail->apartment = $request->apartment;
            $detail->city = $request->city;
            $detail->postal_code = $request->postal_code;
            $detail->dob = $request->dob;
            $detail->vehicle_no = $request->vehicle_no;
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
            $delUserVerify = UserVerify::where('user_id', $id)->delete();
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
