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
use App\Models\Job;
use App\Models\Booking;
use Mail;
use DB;

class JobController extends Controller
{

    public function jobs(Request $request)
    {
        $jobs = Job::where(['status' => 1])->get();
       
        foreach($jobs as $job)
        {
            unset($job->created_at);
            unset($job->updated_at);

            $job->patient = Patient::where('job_id',$job->id)->first();
            $job->history = MedicalHistory::where('job_id',$job->id)->first();
            unset($job->patient->created_at);
            unset($job->patient->updated_at);

            unset($job->history->created_at);
            unset($job->history->updated_at);
        }
        $response = ['data' => $jobs, 'message' => 'Job List', 'success' => true];
        return response()->json($response, 200);
    }

    public function jobDetail(Request $request)
    {
        $job = Job::where(['status' => 1, 'id' => $request->id])->first();
        $job->patient = Patient::where('job_id',$job->id)->first();
        $job->history = MedicalHistory::where('job_id',$job->id)->first();

        unset($job->created_at);
        unset($job->updated_at);
        unset($job->patient->created_at);
        unset($job->patient->updated_at);
        unset($job->history->created_at);
            unset($job->history->updated_at);

        $response = [
            'success' => true,
            'message' => 'Job Detail',
            'job' => $job,
        ];

        return response()->json($response, 200);
    }

    public function updateJob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $jobData = Job::find($request->job_id);
        $jobData->status =  $request->status;
        $jobData->save();

        $delBooking = Booking::where('job_id', $request->job_id)->delete();

        $response = [
            'success' => true,
            'message' => "job status updated",
            'job' => $jobData,
        ];

        return response()->json($response, 200);

    }


}
