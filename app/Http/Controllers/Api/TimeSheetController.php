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
use App\Models\TimeSheet;
use Mail;
use DB;

class TimeSheetController extends Controller
{

    public function uploadTimeSheet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $timeSheet = new TimeSheet();
        $timeSheet->title = $request->title;
        $timeSheet->user_id = auth('api')->user()->id;

        if ($request->hasFile('image')) {
            $name = $request->image->getClientOriginalName();
            $filename =  date('ymdgis') . $name;
            $request->image->move(public_path() . '/storage/timesheet/', $filename);
            $timeSheet->image = '/storage/timesheet/' . $filename;
        }
        $timeSheet->time = date('h:i:s A');
        $timeSheet->date = date('y-m-d');
        $timeSheet->save();
        $response = ['data' => $timeSheet, 'message' => 'timeSheet uploaded', 'success' => true];
        return response()->json($response, 200);
    }

    public function myTimeSheet(Request $request)
    {
        $user_id = Auth::guard('api')->user()->id;
        $timesheets = TimeSheet::where('user_id', $user_id)->get();

        $response = [
            'success' => true,
            'message' => 'TimeSheets List',
            'timesheets' => $timesheets,
        ];

        return response()->json($response, 200);
    }
 
}
