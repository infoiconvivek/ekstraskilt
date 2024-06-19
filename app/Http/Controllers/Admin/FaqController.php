<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Faq;
use Exception;
use File;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $data['faqs'] = Faq::orderBy('id','desc')->paginate(15);
        return view('admin.faq.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.faq.faq-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'status' => 'required'
        ]);

        if (!$request->faq_id) {
            $faq = new Faq();
            $msg = "Faq added successfully.";
        } else {
            $faq = Faq::findOrFail($request->faq_id);
            $msg = "Faq updated successfully.";
        }
       
        try {
            $faq->question = $request->question;
            $faq->answer = $request->answer;
            $faq->status = $request->status;
            $faq->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete', 'status']))
        return redirect()->back()->with(['message' => 'Invalid Action']);

        $faq = Faq::findOrFail($id);

        if ($type == "edit") {
            return view('admin.faq.faq-form', compact('faq'));
        }
        if ($type == "delete") {
            $delData = Faq::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $faq->status = $faq->status == 1 ? 0 : 1;
            $faq->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
