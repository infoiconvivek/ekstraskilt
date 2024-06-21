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

class ProductAttributeController extends Controller
{
    public function index(Request $request)
    {
        $data['attributes'] = ProductAttribute::orderBy('id','desc')->paginate(15);
        return view('admin.product-attribute.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.product-attribute.attribute-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'attribute_id' => 'required',
            'value' => 'required',
        ]);

        if (!$request->product_attribute_id) {
            $attribute = new ProductAttribute();
            $msg = "Product Attribute added successfully.";
        } else {
            $attribute = ProductAttribute::findOrFail($request->product_attribute_id);
            $msg = "Product Attribute updated successfully.";
        }
       
        try {
            $attribute->attribute_id = $request->attribute_id;
            $attribute->value = $request->value;
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

        $attribute = ProductAttribute::findOrFail($id);

        if ($type == "edit") {
            return view('admin.product-attribute.attribute-form', compact('attribute'));
        }
        if ($type == "delete") {
            $delData = ProductAttribute::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }

        return abort(404);
    }

}
