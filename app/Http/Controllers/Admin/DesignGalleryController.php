<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\DesignGallery;
use App\Models\DesignCategory;
use Exception;
use File;
use DB;

class DesignGalleryController extends Controller
{
    public function index(Request $request)
    {
        $data['galleries'] = DesignGallery::orderBy('id', 'desc')->paginate(15);
        return view('admin.design-gallery.index')->with($data);
    }

    public function create(Request $request)
    {
        $data['categories'] = DesignCategory::where('status',1)->orderBy('id', 'asc')->get();
        return view('admin.design-gallery.gallery-form');
    }

    public function getCategory($id)
    {
        $categories = DB::table("design_categories")
                    ->where("type",$id)
                    ->pluck('title','id');
        return json_encode($categories);
    }

   
    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|max:255',
            'type' => 'required',
            'status' => 'required'
        ]);

        if (!$request->gallery_id) {
            $gallery = new DesignGallery();
            $msg = "Gallery Added Successfully.";
        } else {
            $gallery = DesignGallery::findOrFail($request->gallery_id);
            $msg = "Gallery updated Successfully.";
        }

        try {
            $gallery->title = $request->title;

            if ($request->hasFile('image')) {
                $name = $request->image->getClientOriginalName();
                $filename =  date('ymdgis') . $name;
                $request->image->move(public_path() . '/storage/design/', $filename);
                $gallery->image = '/storage/design/' . $filename;
            }
            $gallery->type = $request->type;
            $gallery->category_id = $request->category_id;
            $gallery->status = $request->status;
            $gallery->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete', 'status']))
            return redirect()->back()->with(['message' => 'Invalid Action']);

        $gallery = DesignGallery::findOrFail($id);

        if ($type == "edit") {
            return view('admin.design-gallery.gallery-form', compact('gallery'));
        }
        if ($type == "delete") {
            // if (\File::exists(public_path($gallery->image))) {
            //     \File::delete(public_path($gallery->image));
            // }
            $delData = DesignGallery::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $gallery->status = $gallery->status == 1 ? 0 : 1;
            $gallery->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
