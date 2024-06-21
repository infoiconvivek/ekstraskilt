<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Bilde;
use Exception;
use File;

class BildeController extends Controller
{
    public function index(Request $request)
    {
        $data['bildes'] = Bilde::orderBy('id','desc')->paginate(15);
        return view('admin.bilde.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.bilde.bilde-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required'
        ]);

        if (!$request->bilde_id) {
            $bilde = new Bilde();
            $msg = "Bilde Added Successfully.";
        } else {
            $bilde = Bilde::findOrFail($request->bilde_id);
            $msg = "Bilde updated Successfully.";
        }
       
        try {
            $bilde->title = $request->title;

            if ($request->hasFile('image')) {
                $name = $request->image->getClientOriginalName();
                $filename =  date('ymdgis') . $name;
                $request->image->move(public_path() . '/storage/bilde/', $filename);
                $bilde->image = '/storage/bilde/' . $filename;
            }

            $bilde->order_by = $request->order_by;
            $bilde->status = $request->status;
            $bilde->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete', 'status']))
        return redirect()->back()->with(['message' => 'Invalid Action']);

        $bilde = Bilde::findOrFail($id);

        if ($type == "edit") {
            return view('admin.bilde.bilde-form', compact('bilde'));
        }
        if ($type == "delete") {
            if (\File::exists(public_path($bilde->image))) {
                \File::delete(public_path($bilde->image));
            }
            $delData = Bilde::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $bilde->status = $bilde->status == 1 ? 0 : 1;
            $bilde->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
