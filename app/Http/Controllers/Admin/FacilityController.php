<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Facility;
use Exception;
use File;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $data['facilities'] = Facility::orderBy('id','desc')->paginate(15);
        return view('admin.facility.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.facility.facility-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required'
        ]);

        if (!$request->facility_id) {
            $facility = new Facility();
            $msg = "Facility Added Successfully.";
        } else {
            $facility = Facility::findOrFail($request->facility_id);
            $msg = "Facility updated Successfully.";
        }
       
        try {
            $facility->title = $request->title;
            $facility->status = $request->status;
            $facility->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete', 'status']))
        return redirect()->back()->with(['message' => 'Invalid Action']);

        $facility = Facility::findOrFail($id);

        if ($type == "edit") {
            return view('admin.facility.facility-form', compact('facility'));
        }
        if ($type == "delete") {
            $delData = Facility::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $facility->status = $facility->status == 1 ? 0 : 1;
            $facility->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
