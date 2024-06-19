<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Design;
use App\Models\DesignCategory;
use App\Models\DesignGallery;
use Exception;
use File;

class DesignController extends Controller
{
    public function index(Request $request)
    {
        $data['designs'] = Design::orderBy('id', 'desc')->paginate(15);
        return view('admin.design.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.design.design-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required',
            'status' => 'required'
        ]);

        if (!$request->design_id) {
            $design = new Design();
            $msg = "Design added successfully.";
        } else {
            $design = Design::findOrFail($request->design_id);
            $msg = "Design updated successfully.";
        }

        try {
            $design->title = $request->title;
            $design->design_data = $request->design_data;
            $design->status = $request->status;
            $design->uuid = Str::uuid($request->title . rand(10001, 9999999));
            $design->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }


    public function tool($id)
    {
        ///dd($id);
        $data['images'] = DesignGallery::where(['type'=> 1 , 'category_id' => 18])->orderBy('id', 'asc')->get();
        $data['bg_images'] = DesignGallery::where(['type'=>2])->orderBy('id', 'asc')->get();
        $data['design'] = Design::findOrFail($id);
        $data['image_categories'] = DesignCategory::where(['type'=> 1])->orderBy('id', 'asc')->get();
        $data['bg_categories'] = DesignCategory::where('type',2)->orderBy('id', 'asc')->get();
        return view('admin.design.tool')->with($data);
    }

    public function getToolImages($id)
    {
        $images = DesignGallery::where(['status'=>1,'type'=>1, 'category_id'=>$id])->orderBy('id', 'asc')->get();
        return view('admin.design.tool-gallery',compact('images'))->render();
    }

    public function getToolBgImages($id)
    {
        $bg_images = DesignGallery::where(['status'=>1,'type'=>2, 'category_id'=>$id])->orderBy('id', 'asc')->get();
        return view('admin.design.tool-bg-gallery',compact('bg_images'))->render();
    }

  

    public function toolSave(Request $request)
    {
        $design_id = $request->design_id;
        $design = Design::findOrFail($design_id);
        $design->design_data = $request->design_data;
        ///$design->uuid = Str::uuid($design_id);
        $design->save();
        ///return response()->json(['success' => $design_id]);
        return response()->json(['success' => 'Design updated successfully.']);
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete', 'status']))
            return redirect()->back()->with(['message' => 'Invalid Action']);

        $design = Design::findOrFail($id);

        if ($type == "edit") {
            return view('admin.design.design-form', compact('design'));
        }
        if ($type == "delete") {
            $delData = Design::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $design->status = $design->status == 1 ? 0 : 1;
            $design->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
