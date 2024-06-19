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

class AttributeValueController extends Controller
{
    public function index(Request $request)
    {
        $data['attributes'] = AttributeValue::orderBy('id','desc')->paginate(15);
        return view('admin.attribute-value.index')->with($data);
    }

    public function create(Request $request)
    {
        $data['attributes'] = Attribute::orderBy('id','desc')->get();
        return view('admin.attribute-value.attribute-form')->with($data);
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'attribute_id' => 'required',
            'value' => 'required',
        ]);

        if (!$request->attribute_value_id) {
            $attribute = new AttributeValue();
            $msg = "Attribute Value added successfully.";
        } else {
            $attribute = AttributeValue::findOrFail($request->attribute_value_id);
            $msg = "Attribute Value updated successfully.";
        }
       
        try {
            $attribute->attribute_id = $request->attribute_id;
            $attribute->value = $request->value;
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

        $attribute = AttributeValue::findOrFail($id);
        $attributes = Attribute::orderBy('id','desc')->get();

        if ($type == "edit") {
            return view('admin.attribute-value.attribute-form', compact('attribute','attributes'));
        }
        if ($type == "delete") {
            $delData = AttributeValue::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
       
        return abort(404);
    }
}
