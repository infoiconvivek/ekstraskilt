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
        $data['categories'] = Category::orderBy('id', 'desc')->paginate(15);
        //$data['categories'] = Category::where('parent_id', null)->orderby('id', 'desc')->paginate(15);

        return view('admin.category.index')->with($data);
    }

    public function create(Request $request)
    {
        $categories = Category::where('parent_id', null)->orderby('id', 'desc')->get();
        return view('admin.category.category-form', compact('categories'));
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required',
            'parent_id' => 'nullable|numeric'
        ]);

        if (!$request->category_id) {
            $category = new Category();
            $msg = "Category Added Successfully.";
        } else {
            $category = Category::findOrFail($request->category_id);
            $msg = "Category updated Successfully.";
        }

        try {
            $category->parent_id = $request->parent_id;
            $category->title = $request->title;
            $category->status = $request->status;
            $category->slug = Str::slug($request->title, '-');

            $category->meta_title = $request->meta_title;
            $category->meta_keyword = $request->meta_keyword;
            $category->meta_description = $request->meta_description;


            if ($request->hasFile('image')) {
                $name = $request->image->getClientOriginalName();
                $filename =  date('ymdgis') . $name;
                $request->image->move(public_path() . '/storage/category/', $filename);
                $category->image = '/storage/category/' . $filename;
            }

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
            $categories = Category::where('parent_id', null)->orderby('id', 'desc')->get();
            return view('admin.category.category-form', compact('category', 'categories'));
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