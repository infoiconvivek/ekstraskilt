<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use Exception;
use File;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $data['categories'] = Category::orderBy('id','desc')->paginate(15);
        return view('admin.category.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.category.category-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required'
        ]);

        if (!$request->category_id) {
            $category = new Category();
            $msg = "Category Added Successfully.";
        } else {
            $category = Category::findOrFail($request->category_id);
            $msg = "Category updated Successfully.";
        }
       
        try {
            $category->title = $request->title;
            $category->status = $request->status;
            $category->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete', 'status']))
        return redirect()->back()->with(['message' => 'Invalid Action']);

        $category = Category::findOrFail($id);

        if ($type == "edit") {
            return view('admin.category.category-form', compact('category'));
        }
        if ($type == "delete") {
            $delData = Category::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $category->status = $category->status == 1 ? 0 : 1;
            $category->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
