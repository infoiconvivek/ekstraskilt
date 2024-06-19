<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Page;
use App\Models\PageSection;
use Exception;
use File;

class CmsController extends Controller
{
    public function index(Request $request)
    {
        $data['pages'] = Page::orderBy('id','asc')->paginate(15);
        return view('admin.cms.index')->with($data);
    }

    public function create(Request $request)
    {
        return view('admin.cms.page-form');
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required'
        ]);

        if (!$request->page_id) {
            $page = new Page();
            $msg = "Page added Successfully.";
        } else {
            $page = Page::findOrFail($request->page_id);
            $msg = "Page updated Successfully.";
        }
       
        try {
            $page->title = $request->title;
            $page->descriptions = $request->descriptions;

            if ($request->hasFile('image')) {
                $name = $request->image->getClientOriginalName();
                $filename =  date('ymdgis') . $name;
                $request->image->move(public_path() . '/storage/page/', $filename);
                $page->image = '/storage/page/' . $filename;
            }
            $page->slug = Str::slug($request->title, '-');
            $page->status = $request->status;
            $page->meta_title = $request->meta_title;
            $page->meta_keyword = $request->meta_keyword;
            $page->meta_description = $request->meta_description;
            $page->save();
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

        $page = Page::findOrFail($id);

        if ($type == "edit") {
            return view('admin.cms.page-form', compact('page'));
        }
        if ($type == "delete") {
            if (\File::exists(public_path($page->image))) {
                \File::delete(public_path($page->image));
            }
            $delData = Page::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $page->status = $page->status == 1 ? 0 : 1;
            $page->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }


    public function sectionIndex(Request $request)
    {
        ///$page_id = $request->pid;
        $data['sections'] = PageSection::orderBy('id','desc')->where('page_id',$request->pid)->paginate(25);
        return view('admin.cms.page-section')->with($data);
    }

    public function sectionCreate(Request $request)
    {
        $pages = Page::where('status',1)->get();
        return view('admin.cms.page-section-form',compact('pages'));
    }


    public function sectionSave(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required'
        ]);

        if (!$request->page_section_id) {
            $pageSection = new PageSection();
            $msg = "Page Section added Successfully.";
        } else {
            $pageSection = PageSection::findOrFail($request->page_section_id);
            $msg = "Page Section updated Successfully.";
        }
       
        try {
            $pageSection->page_id = $request->page_id;
            $pageSection->title = $request->title;
            $pageSection->sub_title = $request->sub_title;
            $pageSection->descriptions = $request->descriptions;
            $pageSection->short_desc = $request->short_desc;

            if ($request->hasFile('image')) {
                $name = $request->image->getClientOriginalName();
                $filename =  date('ymdgis') . $name;
                $request->image->move(public_path() . '/storage/pageSection/', $filename);
                $pageSection->image = '/storage/pageSection/' . $filename;
            }
            $pageSection->status = $request->status;
            $pageSection->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function sectionAction($type, $id)
    {
        //dd($type);
        if (!in_array($type, ['edit', 'delete', 'status']))
        return redirect()->back()->with(['message' => 'Invalid Action']);

        $section = PageSection::findOrFail($id);

        if ($type == "edit") {
            $pages = Page::where('status',1)->get();
            return view('admin.cms.page-section-form', compact('section','pages'));
        }
        if ($type == "delete") {
            if (\File::exists(public_path($section->image))) {
                \File::delete(public_path($section->image));
            }
            $delData = Page::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $section->status = $section->status == 1 ? 0 : 1;
            $section->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}
