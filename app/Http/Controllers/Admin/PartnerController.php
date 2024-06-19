<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Partner;
use Exception;
use File;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $data['partners'] = Partner::orderBy('id','desc')->paginate(15);
        return view('admin.partner.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.partner.partner-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required'
        ]);

        if (!$request->partner_id) {
            $partner = new Partner();
            $msg = "Partner Added Successfully.";
        } else {
            $partner = Partner::findOrFail($request->partner_id);
            $msg = "Partner updated Successfully.";
        }
       
        try {
            $partner->title = $request->title;

            if ($request->hasFile('image')) {
                $name = $request->image->getClientOriginalName();
                $filename =  date('ymdgis') . $name;
                $request->image->move(public_path() . '/storage/partner/', $filename);
                $partner->image = '/storage/partner/' . $filename;
            }
            $partner->url = $request->url;
            $partner->status = $request->status;
            $partner->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete', 'status']))
        return redirect()->back()->with(['message' => 'Invalid Action']);

        $partner = Partner::findOrFail($id);

        if ($type == "edit") {
            return view('admin.partner.partner-form', compact('partner'));
        }
        if ($type == "delete") {
            if (\File::exists(public_path($partner->image))) {
                \File::delete(public_path($partner->image));
            }
            $delData = Partner::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $partner->status = $partner->status == 1 ? 0 : 1;
            $partner->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
