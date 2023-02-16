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
use App\Models\TimeSlot;
use App\Models\Slot;
use Mail;
use DB;

class SlotController extends Controller
{

    public function slots(Request $request)
    {
        $user_id = Auth::guard('api')->user()->id;
        $slots = TimeSlot::where('status', 1)->get();

        ///$date = date('Y-m-d'); //today date
        $date = date('Y-m-d',strtotime("-1 days"));
        $weekOfdays = array();
        for($i =1; $i <= 7; $i++){
          $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
          $weekOfdays[] = date('l : Y-m-d', strtotime($date));
        }

        $response = [
            'success' => true,
            'message' => 'slots List',
            'slots' => $slots,
            'weekOfdays' => $weekOfdays,
        ];

        return response()->json($response, 200);
    }


    public function saveSlot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_time' => 'required',
            'to_time' => 'required',
            'date' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $slotCount = Slot::where(['user_id'=>auth('api')->user()->id ,'from_time'=>$request->from_time, 'to_time'=>$request->to_time,'date'=>$request->date])->count();

         if($slotCount != 0)
         {
            $response = ['data' => '', 'message' => 'slot already exist', 'success' => false];
            return response()->json($response, 200);
         }

        $slot = new Slot();
        $slot->user_id = auth('api')->user()->id;
        $slot->from_time = $request->from_time;
        $slot->to_time = $request->to_time;
        $slot->date = $request->date;
        $slot->status = $request->status;
        $slot->save();
        $response = ['data' => $slot, 'message' => 'slot saved', 'success' => true];
        return response()->json($response, 200);
    }

    public function mySlots(Request $request)
    {
        $user_id = Auth::guard('api')->user()->id;
        $slots = Slot::where('user_id', $user_id)->whereDate('date', '>=', now())->get();

        $response = [
            'success' => true,
            'message' => 'slot List',
            'slots' => $slots,
        ];

        return response()->json($response, 200);
    }


    public function deleteSlot(Request $request)
    {
        $user_id = Auth::guard('api')->user()->id;
        $slotCount = Slot::where(['user_id'=>auth('api')->user()->id ,'id'=>$request->slot_id])->count();
        if($slotCount != 1)
        {
           $response = ['data' => '', 'message' => 'slot not exist', 'success' => false];
           return response()->json($response, 200);
        }

        $slots = Slot::where(['user_id' => $user_id, 'id' => $request->slot_id])->delete();

        $response = [
            'success' => true,
            'message' => 'slot deleted successfully',
        ];

        return response()->json($response, 200);
    }
 
}
