<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Ramme;
use Exception;
use File;

class RammeController extends Controller
{
    public function index(Request $request)
    {
        $data['rammes'] = Ramme::orderBy('id', 'desc')->paginate(15);
        return view('admin.ramme.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.ramme.ramme-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required'
        ]);

        if (!$request->ramme_id) {
            $ramme = new Ramme();
            $msg = "Ramme Added Successfully.";
        } else {
            $ramme = Ramme::findOrFail($request->ramme_id);
            $msg = "Ramme updated Successfully.";
        }

        try {
            $ramme->title = $request->title;

            if ($request->hasFile('image')) {
                $name = $request->image->getClientOriginalName();
                $filename =  date('ymdgis') . $name;
                $request->image->move(public_path() . '/storage/ramme/', $filename);
                $ramme->image = '/storage/ramme/' . $filename;
            }

            if ($request->hasFile('svg')) {
                $name = $request->svg->getClientOriginalName();
                $filename =  date('ymdgis') . $name;
                $request->svg->move(public_path() . '/storage/ramme/', $filename);
                $ramme->svg = '/storage/ramme/' . $filename;
            }

            $ramme->order_by = $request->order_by;
            $ramme->status = $request->status;
            $ramme->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete', 'status']))
            return redirect()->back()->with(['message' => 'Invalid Action']);

        $ramme = Ramme::findOrFail($id);

        if ($type == "edit") {
            return view('admin.ramme.ramme-form', compact('ramme'));
        }
        if ($type == "delete") {
            if (\File::exists(public_path($ramme->image))) {
                \File::delete(public_path($ramme->image));
            }
            $delData = Ramme::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $ramme->status = $ramme->status == 1 ? 0 : 1;
            $ramme->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
