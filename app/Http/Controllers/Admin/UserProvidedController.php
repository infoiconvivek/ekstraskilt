<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\UserProvided;
use Exception;
use File;

class UserProvidedController extends Controller
{
    public function index(Request $request)
    {
        $data['categories'] = UserProvided::orderBy('id','desc')->paginate(15);
        return view('admin.provided.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.provided.provided-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required'
        ]);

        if (!$request->category_id) {
            $category = new UserProvided();
            $msg = "UserProvided Added Successfully.";
        } else {
            $category = UserProvided::findOrFail($request->category_id);
            $msg = "UserProvided updated Successfully.";
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

        $category = UserProvided::findOrFail($id);

        if ($type == "edit") {
            return view('admin.provided.provided-form', compact('category'));
        }
        if ($type == "delete") {
            $delData = UserProvided::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $category->status = $category->status == 1 ? 0 : 1;
            $category->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
