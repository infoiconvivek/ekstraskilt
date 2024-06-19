<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use App\Models\ProductImage;
use App\Models\Product;
use App\Helpers\Helper;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product_slug = $request->get('product');
        $data['productlist'] = Product::where('slug', '=', $product_slug)->select('id', 'title', 'slug')->get();
        $data['productimage'] = ProductImage::where('product_id', '=', $data['productlist'][0]->id)
            ->orderBy('id', 'desc')
            ->get();
        // echo "<pre>";
        // print_r($data['productimage']);
        // die();
        return view('admin.productimage.productimage', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $product_slug = $request->get('product');
        $data['productlist'] = Product::where('slug', '=', $product_slug)->select('id', 'slug')->get();
        return view('admin.productimage.add_productimage', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'product_image_name' => 'required',
            'product_image' => 'required|mimes:jpeg,jpg,png,webp',
            //'product_ordering'=>'required|unique:product_images,image_ordering',
        ], [
            'product_image_name.required' => 'Product image name is required',
            'product_image.required' => 'Product image is required',
            'product_image.mimes' => 'Image should be jpeg, jpg, png, webp',
            // 'product_ordering.required'=>'Ordering is required',
            // 'product_ordering.unique'=>'Ordering already used',

            // 'product_image_name.required' => trans('backendmsg.proimage_controller_msg_01'),
            // 'product_image.required' => trans('backendmsg.proimage_controller_msg_02'),
            // 'product_image.mimes' => trans('backendmsg.proimage_controller_msg_03'),
        ]);
        $model = new ProductImage;
        $model->image_name = $request->input('product_image_name');
        $model->product_id = $request->input('product_id');
        $model->image_ordering = $request->input('product_ordering');

        if ($request->hasfile('product_image')) {
            $request->validate([
                'product_image' => 'mimes:jpeg,jpg,png,webp',
            ], [
                'product_image.mimes' => trans('backendmsg.proimage_controller_msg_03'),
            ]);

            // if(Storage::exists('public/products/'.$model->product_lists_id.'/'.$model->image))
            //   {
            //    Storage::delete('public/products/'.$model->product_lists_id.'/'.$model->image);

            //   }
            $file_path = public_path('storage/products/');

            (!file_exists($file_path)) && mkdir($file_path, 0777, true);
            $name = $request->product_image->getClientOriginalName();
            $filename =  date('ymdgis') .  Helper::cleanString($name);
            $request->product_image->move($file_path, $filename);
            $model->image = '/storage/products/' . $filename;
        }

        $model->save();

        $product_slug = $request->input('product_slug');
        //return redirect()->route('admin.productimage.index',['product'=>$product_slug])->with('message', 'Product image added successfully');
        return redirect()->route('productimage.index', ['product' => $product_slug])->with('message', trans('backendmsg.proimage_controller_msg_04'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $data['product_slug'] = $request->get('product');
        $data['product_image'] = ProductImage::where('id', $id)->get();
        return view('admin.productimage.edit_productimage', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'product_image_name' => 'required',
            //'product_image'=>'mimes:jpeg,jpg,png,webp',
        ]);

        $model = ProductImage::where('id', '=', $id)->first();
        $model->image_name = $request->input('product_image_name');
        $model->image_ordering = $request->input('product_ordering');
        if ($request->hasfile('product_image')) {
            $request->validate([
                'product_image' => 'mimes:jpeg,jpg,png,webp',
            ]);

            // if (Storage::exists('storage/products/' . $model->image)) {
            //     Storage::delete('storage/products/' . $model->image);
            // }
            $file_path = public_path('storage/products/');

            (!file_exists($file_path)) && mkdir($file_path, 0777, true);
            $name = $request->product_image->getClientOriginalName();
            $filename =  date('ymdgis') .  Helper::cleanString($name);
            $request->product_image->move($file_path, $filename);
            $model->image = '/storage/products/' . $filename;
        }

        $model->save();
        $product_slug = $request->input('product_slug');
        //return redirect()->route('admin.productimage.index',['product'=>$product_slug])->with('message', 'Product Image Updated successfully');
        return redirect()->route('productimage.index', ['product' => $product_slug])->with('message', trans('backendmsg.proimage_controller_msg_05'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $model = ProductImage::where('id', '=', $id)->first();
        if ($model->image != "") {
            if (Storage::exists('storage/products/' . $model->image)) {
                Storage::delete('storage/products/' . $model->image);
            }
        }
        $model->delete();
        $product_slug = $request->input('product_slug');
        //return redirect()->route('admin.productimage.index',['product'=>$product_slug])->with('message', 'Product image deleted successfully');
        return redirect()->route('productimage.index', ['product' => $product_slug])->with('message', trans('backendmsg.proimage_controller_msg_06'));
    }

    public function status(Request $request, $p_slug, $status, $id)
    {

        $model = ProductImage::where('id', $id)->first();
        $model->images_status = $status;
        $model->save();
        //$request->session()->flash('message', 'Product image status updated');
        $request->session()->flash('message', trans('backendmsg.proimage_controller_msg_07'));
        return redirect()->route('productimage.index', ['product' => $p_slug]);
    }
}
