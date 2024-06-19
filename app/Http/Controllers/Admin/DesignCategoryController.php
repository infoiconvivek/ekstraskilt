<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\DesignCategory;
use Exception;
use File;

class DesignCategoryController extends Controller
{
    public function index(Request $request)
    {
        $data['categories'] = DesignCategory::orderBy('id', 'desc')->paginate(15);
        return view('admin.design-category.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.design-category.category-form');
    }

    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|max:255',
            'type' => 'required',
            'status' => 'required'
        ]);

        if (!$request->category_id) {
            $category = new DesignCategory();
            $msg = "Category Added Successfully.";
        } else {
            $category = DesignCategory::findOrFail($request->category_id);
            $msg = "Category updated Successfully.";
        }

        try {
            $category->title = $request->title;
            $category->type = $request->type;
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

        $category = DesignCategory::findOrFail($id);

        if ($type == "edit") {
            return view('admin.design-category.category-form', compact('category'));
        }
        if ($type == "delete") {
            if (\File::exists(public_path($category->image))) {
                \File::delete(public_path($category->image));
            }
            $delData = DesignCategory::where('id', $id)->delete();
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
