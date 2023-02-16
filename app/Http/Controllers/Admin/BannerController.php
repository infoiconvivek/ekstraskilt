<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Exception;
use File;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $data['banners'] = Banner::orderBy('id','desc')->paginate(15);
        return view('admin.banner.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.banner.banner-form');
    }


    public function save(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required'
        ]);

        if (!$request->banner_id) {
            $banner = new Banner();
            $msg = "Banner Added Successfully.";
        } else {
            $banner = Banner::findOrFail($request->banner_id);
            $msg = "Banner updated Successfully.";
        }
        try {
            $banner->type = 'home';
            $banner->title = $request->title;

            if ($request->hasFile('image')) {
                $name = $request->image->getClientOriginalName();
                $filename =  date('ymdgis') . $name;
                $request->image->move(public_path() . '/storage/banner/', $filename);
                $banner->image = '/storage/banner/' . $filename;
            }
            $banner->status = $request->status;
            $banner->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete', 'status']))
        return redirect()->back()->with(['message' => 'Invalid Action']);

        $banner = Banner::findOrFail($id);

        if ($type == "edit") {
            return view('admin.banner.banner-form', compact('banner'));
        }
        if ($type == "delete") {
            if (\File::exists(public_path($banner->image))) {
                \File::delete(public_path($banner->image));
            }
            $delData = Banner::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $banner->status = $banner->status == 1 ? 0 : 1;
            $banner->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
