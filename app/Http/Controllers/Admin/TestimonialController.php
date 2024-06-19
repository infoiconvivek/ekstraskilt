<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Testimonial;
use Exception;
use File;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $data['testimonials'] = Testimonial::orderBy('id','desc')->paginate(15);
        return view('admin.testimonial.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.testimonial.testimonial-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'name' => 'required|max:255',
            'status' => 'required'
        ]);

        if (!$request->testimonial_id) {
            $testimonial = new Testimonial();
            $msg = "Testimonial added Successfully.";
        } else {
            $testimonial = Testimonial::findOrFail($request->testimonial_id);
            $msg = "Testimonial updated Successfully.";
        }
       
        try {
            $testimonial->name = $request->name;
            $testimonial->designation = $request->designation;

            if ($request->hasFile('image')) {
                $name = $request->image->getClientOriginalName();
                $filename =  date('ymdgis') . $name;
                $request->image->move(public_path() . '/storage/testimonial/', $filename);
                $testimonial->image = '/storage/testimonial/' . $filename;
            }
            $testimonial->message = $request->message;
            $testimonial->status = $request->status;
            $testimonial->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete', 'status']))
        return redirect()->back()->with(['message' => 'Invalid Action']);

        $testimonial = Testimonial::findOrFail($id);

        if ($type == "edit") {
            return view('admin.testimonial.testimonial-form', compact('testimonial'));
        }
        if ($type == "delete") {
            if (\File::exists(public_path($testimonial->image))) {
                \File::delete(public_path($testimonial->image));
            }
            $delData = Testimonial::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $testimonial->status = $testimonial->status == 1 ? 0 : 1;
            $testimonial->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
