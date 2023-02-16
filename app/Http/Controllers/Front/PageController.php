<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Artisan;
use Mail;

class PageController extends Controller
{
   public function index(Request $request)
   {
       ///Artisan::call("storage:link");
       ///Artisan::call("optimize:clear");
      dd('welcome');
   }


}
