<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Materiale;
use Exception;
use File;

class MaterialeController extends Controller
{
    public function index(Request $request)
    {
        $data['materiales'] = Materiale::orderBy('id', 'desc')->paginate(15);
        return view('admin.materiale.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.materiale.materiale-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required'
        ]);

        if (!$request->materiale_id) {
            $materiale = new Materiale();
            $msg = "Materiale Added Successfully.";
        } else {
            $materiale = Materiale::findOrFail($request->materiale_id);
            $msg = "Materiale updated Successfully.";
        }

        try {
            $materiale->title = $request->title;

            if ($request->hasFile('image')) {
                $name = $request->image->getClientOriginalName();
                $filename =  date('ymdgis') . $name;
                $request->image->move(public_path() . '/storage/materiale/', $filename);
                $materiale->image = '/storage/materiale/' . $filename;
            }

            if ($request->hasFile('svg')) {
                $name = $request->svg->getClientOriginalName();
                $filename =  date('ymdgis') . $name;
                $request->svg->move(public_path() . '/storage/materiale/', $filename);
                $materiale->svg = '/storage/materiale/' . $filename;
            }

            $materiale->description = $request->description;
            $materiale->order_by = $request->order_by;
            $materiale->status = $request->status;
            $materiale->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete', 'status']))
            return redirect()->back()->with(['message' => 'Invalid Action']);

        $materiale = Materiale::findOrFail($id);

        if ($type == "edit") {
            return view('admin.materiale.materiale-form', compact('materiale'));
        }
        if ($type == "delete") {
            if (\File::exists(public_path($materiale->image))) {
                \File::delete(public_path($materiale->image));
            }
            $delData = Materiale::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $materiale->status = $materiale->status == 1 ? 0 : 1;
            $materiale->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
