<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Enquiry;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use App\Models\Download;
use App\Models\Page;
use App\Models\Testimonial;
use App\Models\Partner;
use App\Models\Menu;
use App\Models\PageSection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Exception;
use Artisan;
use Mail;
use Captcha;


class PageController extends Controller
{
   public function index(Request $request)
   {
      $data['banner1'] = Banner::orderBy('id','desc')->where(['type' => 'home' , 'id' => 1])->first();
      $data['banner2'] = Banner::orderBy('id','desc')->where(['type' => 'home' , 'id' => 2])->first();
      $data['banner3'] = Banner::orderBy('id','desc')->where(['type' => 'home' , 'id' => 3])->first();
      $data['testimonials'] = Testimonial::orderBy('id','desc')->where('status',1)->get();
      $data['partners'] = Partner::orderBy('id','desc')->where('status',1)->get();
      $data['blogs'] = Blog::orderBy('id','desc')->where('status',1)->get();
      $data['sec1'] = PageSection::orderBy('id','desc')->where('id',1)->first();
      return view('front.index')->with($data);
   }

   public function getMenu()
   {
       $menu = new Menu;
       $menuList = $menu->tree();
       return view('index')->with('menulist', $menuList);
   }

 
   public function blogs(Request $request)
   {
    $data['blogs'] = Blog::orderBy('id','desc')->where('status',1)->get();
    return view('front.blogs')->with($data);
   }

   public function blogDetails(Request $request,$slug)
   {
    $data['blog'] = Blog::orderBy('id','desc')->where('slug',$slug)->first();
    if(! $data['blog'])
    {
        dd('Invalid blog URL');
    }
    return view('front.blog-details')->with($data);
   }


   public function contactUs(Request $request)
   {
    $data['content'] = PageSection::orderBy('id','desc')->where('id',17)->first();
    return view('front.contact')->with($data);
   }

   public function privacyPolicy(Request $request)
   {
    $data['page'] = PageSection::orderBy('id','desc')->where('id',19)->first();
    return view('front.page')->with($data);
   }


   public function termCondition(Request $request)
   {
    $data['page'] = PageSection::orderBy('id','desc')->where('id',21)->first();
    return view('front.terms')->with($data);
   }

   public function track(Request $request)
   {
    $data['page'] = PageSection::orderBy('id','desc')->where('id',22)->first();
    return view('front.track')->with($data);
   }

   public function faq(Request $request)
   {
    $data['page'] = PageSection::orderBy('id','desc')->where('id',22)->first();
    return view('front.faq')->with($data);
   }

   public function aboutUs(Request $request)
   {
    $data['page'] = PageSection::where(['id' => 35, 'status' => 1])->first();
    return view('front.about')->with($data);
   }

   

   
   public function saveEnquiry(Request $request)
   {
       $validate = $request->validate([
           'name' => 'required',
           'email' => 'required|email',
           'phone' => 'required',
           'message' => 'required',
       ]);

       $enq = new Enquiry;
       $enq->name = $request->name;
       $enq->email = $request->email;
       $enq->mobile = $request->phone;
       $enq->message = $request->message;
       $enq->save();

       $arr = [
           'name' => $request->name,
           'email' => $request->email,
           'message' => $request->message,
       ];

       ///Mail::to('gaurav.kumar@infoicon.in')->send(new EnquiryMail($arr));


       return redirect()->back()->with('msg', 'Thank You for Your Inquiry.');
   }


   public function refreshCaptcha()
   {
       return response()->json([
           'captcha' => Captcha::img()
       ]);
   }


}
