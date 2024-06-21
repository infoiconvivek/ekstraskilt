<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Festemetode;
use Exception;
use File;

class FestemetodeController extends Controller
{
    public function index(Request $request)
    {
        $data['festemetodes'] = Festemetode::orderBy('id','desc')->paginate(15);
        return view('admin.festemetode.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.festemetode.festemetode-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required'
        ]);

        if (!$request->festemetode_id) {
            $festemetode = new Festemetode();
            $msg = "Festemetode Added Successfully.";
        } else {
            $festemetode = Festemetode::findOrFail($request->festemetode_id);
            $msg = "Festemetode updated Successfully.";
        }
       
        try {
            $festemetode->title = $request->title;

            if ($request->hasFile('image')) {
                $name = $request->image->getClientOriginalName();
                $filename =  date('ymdgis') . $name;
                $request->image->move(public_path() . '/storage/festemetode/', $filename);
                $festemetode->image = '/storage/festemetode/' . $filename;
            }

            if ($request->hasFile('svg')) {
                $name = $request->svg->getClientOriginalName();
                $filename =  date('ymdgis') . $name;
                $request->svg->move(public_path() . '/storage/festemetode/', $filename);
                $festemetode->svg = '/storage/festemetode/' . $filename;
            }

            $festemetode->description = $request->description;
            $festemetode->order_by = $request->order_by;
            $festemetode->status = $request->status;
            $festemetode->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete', 'status']))
        return redirect()->back()->with(['message' => 'Invalid Action']);

        $festemetode = Festemetode::findOrFail($id);

        if ($type == "edit") {
            return view('admin.festemetode.festemetode-form', compact('festemetode'));
        }
        if ($type == "delete") {
            if (\File::exists(public_path($festemetode->image))) {
                \File::delete(public_path($festemetode->image));
            }
            $delData = Festemetode::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $festemetode->status = $festemetode->status == 1 ? 0 : 1;
            $festemetode->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
