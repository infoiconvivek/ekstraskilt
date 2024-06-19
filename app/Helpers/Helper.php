<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Cart;
use App\Models\PageSection;
use App\Models\Page;
use App\Models\HotelRoomImage;
use App\Models\Setting;
use App\Models\Menu;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\DesignGallery;
use App\Models\ProductAttribute;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Auth;


class Helper
{

  public static function checkTest()
  {
    return 'hello';
  }


  public static function getPageSection($id)
  {
    $section = PageSection::where(['id' => $id, 'status' => 1])->first();
    if ($section) {
      return $section;
    } else {
      return '';
    }
  }

  public static function getSettingData($key)
  {
    $setting = Setting::where(['setting_key' => $key])->first();
    return $setting->setting_value;
  }

  public static function getLogo()
  {
    return Admin::where(['id' => 2])->first()->image;
  }

  public static function getInnerBanner($type)
  {
    return Banner::where(['type' => $type])->first();
  }

  public static function slug_text($text)
  {
    return $slug = Str::slug($text);
  }

  public static function getDesignGallery($category_id)
  {
    return DesignGallery::where(['category_id' => $category_id])->get();
  }

  public static function getPrdctAttrVals($product_id,$attribute_id)
  {
    return ProductAttribute::where(['product_id' => $product_id,'attribute_id' => $attribute_id])->get();
  }


  public static function getPrdctAttrValus($attribute_id)
  {
    return AttributeValue::where(['attribute_id' => $attribute_id])->get();
  }

  public static function getPageData($id)
  {
    $page = Page::where(['id' => $id, 'status' => 1])->first();
     return $page;
  }

  public static function getPageSectionData($id)
  {
    $page = PageSection::where(['id' => $id, 'status' => 1])->first();
     return $page;
  }


  public static function getBlogData()
  {
     $blogs = Blog::where(['status' => 1])->orderBy('id','desc')->take(3)->get();
     return $blogs;
  }

  public static function getFooterMenu()
  {
     $menus = Menu::where(['status' => 1,'type'=>'footer'])->orderBy('sort_order','desc')->get();
     return $menus;
  }


  public static function cartCount()
  {
    $carts = Session::get('cart', []);
    return count($carts);
  }


  
  public function getMenu()
   {
       $menu = new Menu;
       $menuList = $menu->tree();
       return $menuList;
   }

   function cleanString($string) {
    $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
    return str_replace( array( '\'', '"', ',' , ';', '<', '>', '(', ')' ), ' ', $string);
    ///return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes
    ///return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 }



}
