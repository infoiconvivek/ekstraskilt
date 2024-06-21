<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Menu;
use Exception;
use File;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $data['menus'] = Menu::orderBy('id','desc')->paginate(15);
        return view('admin.menu.index')->with($data);
    }

    public function create(Request $request)
    {
        $parent_menu = Menu::where('parent_id',0)->get();
        return view('admin.menu.menu-form',compact('parent_menu'));
    }


    public function save(Request $request)
    {
        //
        $validated = $request->validate([
            'menu_title' => 'required',
            'parent_id' => 'required',
            'status' => 'required'
        ]);

        if (!$request->menu_id) {
            $menu = new Menu();
            $msg = "Menu added successfully.";
        } else {
            $menu = Menu::findOrFail($request->menu_id);
            $msg = "Menu updated successfully.";
        }
       
        try {
            $menu->menu_title = $request->menu_title;
            $menu->parent_id = $request->parent_id;
            $menu->sort_order = $request->sort_order;
            $menu->slug	 = Str::slug($request->slug, '-');
            $menu->type	 = $request->type;
            $menu->save();
            return redirect()->back()->with(["msg" => $msg, 'msg_type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(["msg" => $e->getMessage(), 'msg_type' => 'danger']);
        }
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['edit', 'delete', 'status']))
        return redirect()->back()->with(['message' => 'Invalid Action']);

        $menu = Menu::findOrFail($id);

        if ($type == "edit") {
            $parent_menu = Menu::where('parent_id',0)->get();
            return view('admin.menu.menu-form', compact('menu','parent_menu'));
        }
        if ($type == "delete") {
            $delData = Menu::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
        if ($type == "status") {
            $menu->status = $menu->status == 1 ? 0 : 1;
            $menu->save();
            return redirect()->back()->with(['message' => 'Status changed successfully.']);
        }
        return abort(404);
    }
}