<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DesignGallery;
use App\Models\Design;
use App\Models\DesignCategory;
use App\Models\Category;
use App\Models\Product;
use App\Models\Download;
use App\Models\Page;
use App\Models\Testimonial;
use App\Models\Partner;
use App\Models\Menu;
use App\Models\PageSection;
use App\Models\Materiale;
use App\Models\Festemetode;
use App\Models\Bilde;
use App\Models\Form;
use App\Models\Ramme;
use App\Models\Storrelse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Exception;
use Artisan;
use Mail;
use Captcha;


class ToolController extends Controller
{
   public function index(Request $request)
   {
      $data['images'] = DesignGallery::where(['type'=> 1 , 'category_id' => 18])->orderBy('id', 'asc')->get();
      $data['bg_images'] = DesignGallery::where(['type'=>2])->orderBy('id', 'asc')->get();
      ///$data['design'] = Design::findOrFail($id);
      $data['image_categories'] = DesignCategory::where(['type'=> 1])->orderBy('id', 'asc')->get();
      $data['bg_categories'] = DesignCategory::where('status',1)->orderBy('id', 'asc')->get();

      $data['materiales'] = Materiale::where(['status'=>1])->orderBy('order_by', 'asc')->get();
      $data['festemetodes'] = Festemetode::where(['status'=>1])->orderBy('order_by', 'asc')->get();
      $data['bildes'] = Bilde::where(['status'=>1])->orderBy('order_by', 'asc')->get();
      $data['forms'] = Form::where(['status'=>1])->orderBy('order_by', 'asc')->get();
      $data['rammes'] = Ramme::where(['status'=>1])->orderBy('order_by', 'asc')->get();
      $data['storrelses'] = Storrelse::where(['status'=>1])->orderBy('order_by', 'asc')->get();
      return view('tool.index')->with($data);
   }

   public function getToolImages($id)
   {
       $images = DesignGallery::where(['status'=>1,'type'=>1, 'category_id'=>$id])->orderBy('id', 'asc')->get();
       return view('admin.design.tool-gallery',compact('images'))->render();
   }

   public function getToolBgImages($id)
   {
       $bg_images = DesignGallery::where(['status'=>1,'type'=>2, 'category_id'=>$id])->orderBy('id', 'asc')->get();
       return view('admin.design.tool-bg-gallery',compact('bg_images'))->render();
   }

 

   public function toolSave(Request $request)
   {
       $design_id = $request->design_id;
       $design = Design::findOrFail($design_id);
       $design->design_data = $request->design_data;
       ///$design->uuid = Str::uuid($design_id);
       $design->save();
       ///return response()->json(['success' => $design_id]);
       return response()->json(['success' => 'Design updated successfully.']);
   }




}
