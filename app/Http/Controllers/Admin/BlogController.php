<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Blog;
use Exception;
use File;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $data['blogs'] = Blog::orderBy('id','desc')->paginate(15);
        return view('admin.blog.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.blog.blog-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required'
        ]);

        if (!$request->blog_id) {
            $blog = new Blog();
            $msg = "Blog added Successfully.";
        } else {
            $blog = Blog::findOrFail($request->blog_id);
            $msg = "Blog updated Successfully.";
        }
       
        try {
            $blog->title = $request->title;
            $blog->short_desc = $request->short_desc;
            $blog->descriptions = $request->descriptions;

            if ($request->hasFile('image')) {
                $name = $request->image->getClientOriginalName();
                $filename =  date('ymdgis') . $name;
                $request->image->move(public_path() . '/storage/blog/', $filename);
                $blog->image = '/storage/blog/' . $filename;
            }
            $blog->author = $request->author;
            $blog->date = $request->date;
            $blog->slug = Str::slug($request->title, '-');
            $blog->status = $request->status;
            $blog->meta_title = $request->meta_title;
            $blog->meta_keyword = $request->meta_keyword;
            $blog->meta_description = $request->meta_description;
            $blog->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        //dd($type);
        if (!in_array($type, ['edit', 'delete', 'status']))
        return redirect()->back()->with(['message' => 'Invalid Action']);

        $blog = Blog::findOrFail($id);

        if ($type == "edit") {
            return view('admin.blog.blog-form', compact('blog'));
        }
        if ($type == "delete") {
            if (\File::exists(public_path($blog->image))) {
                \File::delete(public_path($blog->image));
            }
            $delData = Blog::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $blog->status = $blog->status == 1 ? 0 : 1;
            $blog->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
