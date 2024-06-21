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

class AttributeController extends Controller
{
    public function index(Request $request)
    {
        $data['attributes'] = Attribute::orderBy('id','desc')->paginate(15);
        return view('admin.attribute.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.attribute.attribute-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);

        if (!$request->attribute_id) {
            $attribute = new Attribute();
            $msg = "Attribute added successfully.";
        } else {
            $attribute = Attribute::findOrFail($request->attribute_id);
            $msg = "Attribute updated successfully.";
        }
       
        try {
            $attribute->name = $request->name;
            $attribute->type = $request->type;
            $attribute->status = $request->status;
            $attribute->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete']))
        return redirect()->back()->with(['message' => 'Invalid Action']);

        $attribute = Attribute::findOrFail($id);

        if ($type == "edit") {
            return view('admin.attribute.attribute-form', compact('attribute'));
        }
        if ($type == "delete") {
            $delData = Attribute::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
       
        return abort(404);
    }
}
