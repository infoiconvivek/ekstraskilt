<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Form;
use Exception;
use File;

class FormController extends Controller
{
    public function index(Request $request)
    {
        $data['forms'] = Form::orderBy('id', 'desc')->paginate(15);
        return view('admin.form.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.form.tform-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required'
        ]);

        if (!$request->form_id) {
            $form = new Form();
            $msg = "Form Added Successfully.";
        } else {
            $form = Form::findOrFail($request->form_id);
            $msg = "Form updated Successfully.";
        }

        try {
            $form->title = $request->title;

            if ($request->hasFile('image')) {
                $name = $request->image->getClientOriginalName();
                $filename =  date('ymdgis') . $name;
                $request->image->move(public_path() . '/storage/form/', $filename);
                $form->image = '/storage/form/' . $filename;
            }

            if ($request->hasFile('svg')) {
                $name = $request->svg->getClientOriginalName();
                $filename =  date('ymdgis') . $name;
                $request->svg->move(public_path() . '/storage/form/', $filename);
                $form->svg = '/storage/form/' . $filename;
            }

            $form->order_by = $request->order_by;
            $form->status = $request->status;
            $form->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete', 'status']))
            return redirect()->back()->with(['message' => 'Invalid Action']);

        $form = Form::findOrFail($id);

        if ($type == "edit") {
            return view('admin.form.tform-form', compact('form'));
        }
        if ($type == "delete") {
            if (\File::exists(public_path($form->image))) {
                \File::delete(public_path($form->image));
            }
            $delData = Form::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $form->status = $form->status == 1 ? 0 : 1;
            $form->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
