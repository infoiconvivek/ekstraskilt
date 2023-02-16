<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Job;
use App\Models\Patient;
use App\Models\MedicalHistory;
use App\Models\Position;
use App\Models\Facility;
use App\Models\Notification;
use App\Services\FirebaseServices;
use Exception;
use File;

class JobController extends Controller
{

    public function __construct(FirebaseServices $firebaseServices)
    {
        $this->firebaseServices = $firebaseServices;
    }


    public function index(Request $request)
    {
        $data['jobs'] = Job::orderBy('id','desc')->paginate(15);
        return view('admin.job.index')->with($data);
    }

    public function create(Request $request)
    {
        $data['facilities'] = Facility::orderBy('id','desc')->get();
        $data['positions'] = Position::orderBy('id','desc')->get();
        return view('admin.job.job-form')->with($data);
    }


    public function save(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required'
        ]);

        if (!$request->job_id) {
            $job = new Job();
            $msg = "New job posted ".$request->title;
            $notify_msg = "New job posted ".$request->title;
        } else {
            $job = Job::findOrFail($request->job_id);
            $msg = $request->title. " updated kindly refer";
            $notify_msg = $request->title. " updated kindly refer";
        }

        $this->firebaseServices->sendNotification(['title' => $msg, 'body' => $notify_msg, 'token' => '', 'user_id' => '']);
       
        try {
            $job->title = $request->title;
            $job->location = $request->location;
            $job->time_from = date('h:i:s A', strtotime( $request->time_from));
            $job->time_to = date('h:i:s A', strtotime( $request->time_to));
            $job->date = $request->date;
            $job->facility = $request->facility;
            $job->position = $request->position;
            $job->descriptions = $request->descriptions;
            $job->slug = Str::slug($request->title, '-');
            $job->status = $request->status;
            $job->save();

            $patient = Patient::firstOrNew(['job_id' =>  $job->id]);
            $patient->job_id = $job->id;
            $patient->name = $request->name;
            $patient->dob = $request->dob;
            $patient->gender = $request->gender;
            $patient->state = $request->state;
            $patient->city = $request->city;
            $patient->zip_code = $request->zip_code;
            $patient->save();

            $history = MedicalHistory::firstOrNew(['job_id' =>  $job->id]);
            $history->job_id = $job->id;
            $history->title = $request->history_title;
            $history->desc = $request->history_desc;
            $history->save();

            $notification = new Notification();
            $notification->user_id = 0;
            $notification->title = $notify_msg;
            $notification->message = $notify_msg;
            $notification->save();


            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        //dd($type);
        if (!in_array($type, ['edit', 'delete', 'status']))
        return redirect()->back()->with(['message' => 'Invalid Action']);

        $job = Job::findOrFail($id);
        $job->patient = Patient::where('job_id',$job->id)->first();
        $job->history = MedicalHistory::where('job_id',$job->id)->first();

        
        ///dd($job);

        if ($type == "edit") {
            $facilities = Facility::orderBy('id','desc')->get();
            $positions = Position::orderBy('id','desc')->get();
            $job->time_from = date('H:i:s',strtotime( $job->time_from));
            $job->time_to = date('H:i:s',strtotime( $job->time_to));
            return view('admin.job.job-form', compact('job','facilities','positions'));
        }
        if ($type == "delete") {
            $delPatient = Patient::where('job_id', $id)->delete();
            $delMedicalHistory = MedicalHistory::where('job_id', $id)->delete();
            $delData = Job::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $job->status = $job->status == 1 ? 0 : 1;
            $job->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
