<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Variation;
use Exception;
use File;

class VariationController extends Controller
{
    public function index(Request $request)
    {
        $data['variations'] = Variation::orderBy('id','desc')->paginate(15);
        return view('admin.variation.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.variation.variation-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'type' => 'required',
            'name' => 'required',
            'status' => 'required'
        ]);

        if (!$request->variation_id) {
            $variation = new Variation();
            $msg = "Variation added successfully.";
        } else {
            $variation = Variation::findOrFail($request->variation_id);
            $msg = "Variation updated successfully.";
        }
       
        try {
            $variation->name = $request->name;
            $variation->type = $request->type;
            $variation->status = $request->status;
            $variation->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete']))
        return redirect()->back()->with(['message' => 'Invalid Action']);

        $variation = Variation::findOrFail($id);

        if ($type == "edit") {
            return view('admin.variation.variation-form', compact('attribute'));
        }
        if ($type == "delete") {
            $delData = Variation::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
       
        return abort(404);
    }
}
