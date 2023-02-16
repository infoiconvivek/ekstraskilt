<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use App\Models\PageSection;
use Illuminate\Support\Facades\Http;
use Auth;


class Helper
{

  public static function checkTest()
  {
    return 'hello';
  }


  public static function getPageSection($id)
  {
    $section = PageSection::where(['id'=>$id,'status'=>1])->first();
    if($section)
    {
        return $section;
    } else
    {
        return '';
    }
   
  }


}