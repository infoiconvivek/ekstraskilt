<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Storrelse;
use Exception;
use File;

class StorrelseController extends Controller
{
    public function index(Request $request)
    {
        $data['storrelses'] = Storrelse::orderBy('id','desc')->paginate(15);
        return view('admin.storrelse.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.storrelse.storrelse-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'bredde' => 'required',
            'hoyde' => 'required',
            'status' => 'required'
        ]);

        if (!$request->storrelse_id) {
            $storrelse = new Storrelse();
            $msg = "Storrelse Added Successfully.";
        } else {
            $storrelse = Storrelse::findOrFail($request->storrelse_id);
            $msg = "Storrelse updated Successfully.";
        }
       
        try {
            $storrelse->bredde = $request->bredde;
            $storrelse->hoyde = $request->hoyde;
            $storrelse->order_by = $request->order_by;
           
            $storrelse->status = $request->status;
            $storrelse->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete', 'status']))
        return redirect()->back()->with(['message' => 'Invalid Action']);

        $storrelse = Storrelse::findOrFail($id);

        if ($type == "edit") {
            return view('admin.storrelse.storrelse-form', compact('storrelse'));
        }
        if ($type == "delete") {
            if (\File::exists(public_path($storrelse->image))) {
                \File::delete(public_path($storrelse->image));
            }
            $delData = Storrelse::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $storrelse->status = $storrelse->status == 1 ? 0 : 1;
            $storrelse->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
