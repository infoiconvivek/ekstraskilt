<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\CovidVaccine;
use Exception;
use File;

class VaccineController extends Controller
{
    public function index(Request $request)
    {
        $data['categories'] = CovidVaccine::orderBy('id','desc')->paginate(15);
        return view('admin.vaccine.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.vaccine.vaccine-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required'
        ]);

        if (!$request->category_id) {
            $category = new CovidVaccine();
            $msg = "Vaccine Added Successfully.";
        } else {
            $category = CovidVaccine::findOrFail($request->category_id);
            $msg = "Vaccine updated Successfully.";
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

        $category = CovidVaccine::findOrFail($id);

        if ($type == "edit") {
            return view('admin.vaccine.vaccine-form', compact('category'));
        }
        if ($type == "delete") {
            $delData = CovidVaccine::where('id', $id)->delete();
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
