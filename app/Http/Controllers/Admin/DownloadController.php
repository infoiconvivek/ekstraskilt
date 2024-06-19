<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Download;
use Exception;
use File;

class DownloadController extends Controller
{
    public function index(Request $request)
    {
        $data['downloads'] = Download::orderBy('id','desc')->paginate(15);
        return view('admin.download.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.download.download-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required'
        ]);

        if (!$request->download_id) {
            $download = new Download();
            $msg = "Download added Successfully.";
        } else {
            $download = Download::findOrFail($request->download_id);
            $msg = "Download updated Successfully.";
        }
       
        try {
            $download->title = $request->title;
            $download->file_title = $request->file_title;
            $download->file_extension_name = $request->file_extension_name;
            $download->descriptions = $request->descriptions;

            if ($request->hasFile('file_name')) {
                $name = $request->file_name->getClientOriginalName();
                $filename =  date('ymdgis') . $name;
                $request->file_name->move(public_path() . '/storage/download/', $filename);
                $download->file_name = '/storage/download/' . $filename;
            }

            $download->status = $request->status;
            $download->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        //dd($type);
        if (!in_array($type, ['edit', 'delete', 'status']))
        return redirect()->back()->with(['message' => 'Invalid Action']);

        $download = Download::findOrFail($id);

        if ($type == "edit") {
            return view('admin.download.download-form', compact('download'));
        }
        if ($type == "delete") {
            if (\File::exists(public_path($download->file_name))) {
                \File::delete(public_path($download->file_name));
            }
            $delData = Download::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $download->status = $download->status == 1 ? 0 : 1;
            $download->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
