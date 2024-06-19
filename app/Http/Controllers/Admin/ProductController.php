<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use App\Models\Variation;
use App\Models\Category;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use Exception;
use File;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $data['products'] = Product::orderBy('id', 'desc')->paginate(15);
        return view('admin.product.index')->with($data);
    }

    public function create(Request $request)
    {
        $data['categories'] = Category::where('parent_id', null)->orderby('id', 'desc')->get();
        $data['attributes'] = Attribute::orderBy('id','desc')->get();
        $data['product_attributes'] = [];
        return view('admin.product.product-form')->with($data);
    }

    public function getAttributeVal($attribute_id)
    {
        $attributeValues = AttributeValue::where('attribute_id', $attribute_id)->get();
        return response()->json($attributeValues);
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            ///'category_id' => 'required|max:255',
            'title' => 'required|max:255',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required'
        ]);

        if (!$request->product_id) {
            $product = new Product();
            $msg = "Product Added Successfully.";
        } else {
            $product = Product::findOrFail($request->product_id);
            $msg = "Product updated Successfully.";
        }
        try {
            $product->category_id = $request->category_id;
            $product->title = $request->title;
            $product->slug = Str::slug($request->title, '-');
            $product->price = $request->price;
            $product->sell_price = $request->sell_price;
            $product->design_id = $request->design_id;
            $product->description = $request->short_description;
            $product->content = $request->content;
            $product->sku = $request->sku;
            $product->status = $request->status;


            if ($request->hasFile('thumbnail')) {
                $file_path = public_path('storage/products/');

                (!file_exists($file_path)) && mkdir($file_path, 0777, true);
                $name = $request->thumbnail->getClientOriginalName();
                $filename =  date('ymdgis') .  Helper::cleanString($name);
                $request->thumbnail->move($file_path, $filename);
                $product->thumbnail = $filename;
            }
            //dd($product);
            $product->save();

            $product_attribute = ProductAttribute::firstOrNew(['product_id' =>  $product->id, 'attribute_id'=>$request->attribute_id, 'attribute_value_id'=>$request->attribute_value_id]);
           
            if($request->attribute_id != '')
            {
                $product_attribute->product_id = $product->id;
                $product_attribute->attribute_id = $request->attribute_id;
                $product_attribute->attribute_value_id = $request->attribute_value_id;
                $product_attribute->status = 1;
                $product_attribute->save();
            }
            
            if ($request->gallery_title != '') {
                $gallery = new ProductGallery();
                $gallery->product_id = $product->id;
                $gallery->title = $request->gallery_title;

                if ($request->hasFile('gallery_image')) {
                    $galname = $request->gallery_image->getClientOriginalName();
                    $gal_filename =  date('ymdgis') . $galname;
                    $request->gallery_image->move(public_path() . '/storage//product/gallery/', $gal_filename);
                    $gallery->image = '/storage/product/gallery/' . $gal_filename;
                }
                $gallery->order_by = $request->gallery_orderby;
                $gallery->save();
            }



            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }


    public function generateVariations(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $attributes = $request->attributes;
        $variations = $this->generateCombinations($attributes);

        foreach ($variations as $variation) {
            $product->variations()->create([
                'attributes' => json_encode($variation),
                'price' => $request->price,
            ]);
        }

        return response()->json($product->load('variations'));
    }

    private function generateCombinations($arrays)
    {
        $result = [[]];
        foreach ($arrays as $property => $propertyValues) {
            $tmp = [];
            foreach ($result as $resultItem) {
                foreach ($propertyValues as $propertyValue) {
                    $tmp[] = array_merge($resultItem, [$property => $propertyValue]);
                }
            }
            $result = $tmp;
        }
        return $result;
    }


    public function deleteData(Request $request, $type)
    {
        $id = $request->id;
        if($type == 'gallery')
        {
            $delData= ProductGallery::where('id', $id)->delete();
        }
        
        if($type == 'product_attribute')
        {
            $delData= ProductAttribute::where('id', $id)->delete();
        }

        return redirect()->back()->with(['message' => 'Record deleted successfully.']);
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete', 'status']))
            return redirect()->back()->with(['message' => 'Invalid Action']);

        $product = Product::findOrFail($id);
        //$categories = Category::orderBy('id', 'desc')->get();
        $categories = Category::where('parent_id', null)->orderby('id', 'desc')->get();
        $attributes = Attribute::orderBy('id','desc')->get();
        $product_attributes = ProductAttribute::where('product_id',$id)->orderBy('id','desc')->get();
        $variat_attributes = ProductAttribute::where(['product_id'=>$id])->groupBy('attribute_id')->get();
        if ($type == "edit") {
         $product_galleries = ProductGallery::where('product_id', $id)->orderby('id','desc')->get();
         ///$data['variations'] = Attribute::orderBy('id','desc')->get();
            return view('admin.product.product-form', compact('product', 'categories','attributes','product_attributes','product_galleries','variat_attributes'));
        }
        if ($type == "delete") {
            $delData1 = ProductAttribute::where('product_id', $id)->delete();
            $delData2 = ProductGallery::where('product_id', $id)->delete();
            $delData = Product::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $product->status = $product->status == 1 ? 0 : 1;
            $product->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
