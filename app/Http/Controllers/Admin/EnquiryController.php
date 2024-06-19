<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use Exception;
use File;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        $data['enquiries'] = Enquiry::orderBy('id','desc')->paginate(15);
        return view('admin.enquiry.index')->with($data);
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['view', 'delete']))
        return redirect()->back()->with(['message' => 'Invalid Action']);

        $enquiry = Enquiry::findOrFail($id);

        if ($type == "view") {
            return view('admin.enquiry.view', compact('enquiry'));
        }

        if ($type == "delete") {
            $delData = Enquiry::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
    
        return abort(404);
    }

}
