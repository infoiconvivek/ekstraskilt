<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Position;
use Exception;
use File;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        $data['positions'] = Position::orderBy('id','desc')->paginate(15);
        return view('admin.position.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.position.position-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required'
        ]);

        if (!$request->position_id) {
            $category = new Position();
            $msg = "Position Added Successfully.";
        } else {
            $category = Position::findOrFail($request->position_id);
            $msg = "Position updated Successfully.";
        }
       
        try {
            $category->title = $request->title;
            $category->status = $request->status;
            $category->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete', 'status']))
        return redirect()->back()->with(['message' => 'Invalid Action']);

        $position = Position::findOrFail($id);

        if ($type == "edit") {
            return view('admin.position.position-form', compact('position'));
        }
        if ($type == "delete") {
            $delData = Position::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $position->status = $position->status == 1 ? 0 : 1;
            $position->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
