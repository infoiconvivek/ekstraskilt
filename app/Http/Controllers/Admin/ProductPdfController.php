<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductPdf;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Exception;

class ProductPdfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $product_slug = $request->get('product');
        $product = Product::where('slug', '=', $product_slug)->select('id', 'title', 'slug')->first();
        $data = ProductPdf::where('product_id', '=', $product->id)->orderBy('id', 'desc')->paginate(15);
        return view('admin.productpdf.list', compact('data', 'product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $product_slug = $request->get('product');
        $product = Product::where('slug', '=', $product_slug)->select('id', 'title', 'slug')->first();
        return view('admin.productpdf.form', compact('product'));
    }
    /**
     * Store and update resource in storage.
     */

    public function save(Request $request)
    {

        $request->validate([
            'pdf_name' => 'required|max:255',
        ]);

        if (!$request->pdf_id) {
            $model = new ProductPdf();
            $msg = "Product pdf Added Successfully.";
        } else {
            $produc_id = (int)$request['pdf_id'];
            $model = ProductPdf::findOrFail($produc_id);
            $msg = "Product pdf updated Successfully.";
        }

        try {

            $model->pdf_name = $request->input('pdf_name');
            $model->product_id = $request->input('product_id');
            $model->pdf_ordering = $request->input('pdf_ordering');


            if ($request->hasFile('product_pdf')) {
                $file_path = public_path('storage/products/');

                (!file_exists($file_path)) && mkdir($file_path, 0777, true);
                $name = $request->product_pdf->getClientOriginalName();
                $filename =  date('ymdgis') .  Helper::cleanString($name);
                $request->product_pdf->move($file_path, $filename);
                $model->pdf = '/storage/products/' . $filename;
            }
            //dd($model);
            $model->save();

            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action(Request $request, $type, $id)
    {

        if (!in_array($type, ['edit', 'delete', 'status']))
            return redirect()->back()->with(['message' => 'Invalid Action']);

        $productpdf = ProductPdf::findOrFail($id);
        $product_slug = $request->get('product');
        $product = Product::where('slug', '=', $product_slug)->select('id', 'title', 'slug')->first();

        if ($type == "edit") {
            return view('admin.productpdf.form', compact('productpdf', 'product'));
        }
        if ($type == "delete") {
            $delData = Product::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $productpdf->status = $productpdf->status == 1 ? 0 : 1;
            $productpdf->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
