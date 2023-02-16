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
use App\Models\Patient;
use App\Models\MedicalHistory;
use App\Models\Booking;
use App\Models\Job;
use Mail;
use DB;

class BookingController extends Controller
{

    public function Booking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $job = Job::where(['status' => 1, 'id' => $request->job_id])->first();
        if ($job) {

            $bookCount = Booking::where(['user_id' => auth('api')->user()->id, 'job_id' => $request->job_id])->count();
             if($bookCount < 1)
             {
                $booking = new Booking();
                $booking->user_id = auth('api')->user()->id;
                $booking->job_id = $request->job_id;
                $booking->status = 1;
                $booking->save();
                $msg = "Job booked successfully";

                $jobData = Job::find($request->job_id);
                $jobData->status =  2;
                $jobData->save();
             } else
             {
                $booking = [];
                $msg = "Job already applied";
             }

        } else {
            $booking = [];
            $msg = "Job does not exist";
        }

        $response = [
            'success' => true,
            'message' => $msg,
            'job' => $booking,
        ];

        return response()->json($response, 200);
    }



    public function myBooking(Request $request)
    {
        $user_id = Auth::guard('api')->user()->id;
        $booking = Booking::where('user_id', $user_id)->get();

        foreach($booking as $order)
        {
            unset($order->created_at);
            unset($order->updated_at);

                  $order->job = Job::where(['id' => $order->job_id])->first();
                  $order->patient = Patient::where('job_id',$order->job_id)->first();
                  $order->history = MedicalHistory::where('job_id',$order->job_id)->first();
                unset($order->patient->created_at);
                unset($order->patient->updated_at);
    
                unset($order->history->created_at);
                unset($order->history->updated_at);
           
        }

        $response = [
            'success' => true,
            'message' => 'booking List',
            'booking' => $booking,
        ];

        return response()->json($response, 200);
    }


}
