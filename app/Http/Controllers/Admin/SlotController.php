<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slot;
use App\Models\TimeSlot;
use Exception;
use File;

class SlotController extends Controller
{
    public function index(Request $request)
    {
        $data['slots'] = TimeSlot::orderBy('id','desc')->paginate(15);
        return view('admin.slot.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.slot.slot-form');
    }


    public function save(Request $request)
    {
        $validated = $request->validate([
            'from_time' => 'required',
            'to_time' => 'required',
            'status' => 'required'
        ]);

        if (!$request->slot_id) {
            $slot = new TimeSlot();
            $msg = "Slot Added Successfully.";
        } else {
            $slot = TimeSlot::findOrFail($request->slot_id);
            $msg = "Slot updated Successfully.";
        }
        try {
            $slot->from_time = date('h:i:s A', strtotime( $request->from_time));
            $slot->to_time = date('h:i:s A', strtotime( $request->to_time));
            $slot->status = $request->status;
            $slot->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete', 'status']))
        return redirect()->back()->with(['message' => 'Invalid Action']);

        $slot = TimeSlot::findOrFail($id);

        if ($type == "edit") {
            $slot->from_time = date('H:i:s',strtotime( $slot->from_time));
            $slot->to_time = date('H:i:s',strtotime( $slot->to_time));
            return view('admin.slot.slot-form', compact('slot'));
        }
        if ($type == "delete") {
            $delData = TimeSlot::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $slot->status = $slot->status == 1 ? 0 : 1;
            $slot->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
