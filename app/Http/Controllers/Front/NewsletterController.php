<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Enquiry;
use App\Models\Newsletter;
use App\Interfaces\HotelRepositoryInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Mail\NewsletterMail;
use App\Mail\NewsletterConfirmMail;
use Illuminate\Support\Str;
use Exception;
use Artisan;
use Mail;

class NewsletterController extends Controller
{
  public function saveNewsletter(Request $request)
  {

    $email = $request->email;
    if (isset($request->email) && $request->email != '') {

      $emailCount = Newsletter::where('email', $email)->count();
      if ($emailCount > 0) {
        return response()->json(['status' => 200, 'msgType' => 'Success', 'msg' => 'Email Id Already exists']);
      } else {
        $token = Str::uuid($request->email);
        $newsletter = new Newsletter;
        $newsletter->email = $request->email;
        $newsletter->token = $token;
        $newsletter->status = 0;
        $newsletter->save();

        $arr = [
          'email' => $request->email,
          'token' => $token,
        ];

        ///Mail::to($request->email)->send(new NewsletterMail($arr));

        return response()->json(['status' => 200, 'msgType' => 'Success', 'msg' => 'Thank You! You have been subscribed.']);
      }
    } else {
      return response()->json(['status' => 400, 'msgType' => 'Failure', 'msg' => 'Please enter Email Id']);
    }
  }

  public function newsletterVerification(Request $request)
  {
    $emailCount = Newsletter::where('token', $request->token)->count();
    if ($emailCount > 0) {
      $emailData = Newsletter::where('token', $request->token)->first();
      $update = Newsletter::where(['token' => $request->token])->update(['status' => 1]);
      $arr = [
        'email' => $emailData->email,
        'token' => Str::uuid($request->email),
      ];
      $localteLang =  $this->getLocaleLang();
      ///Mail::to($emailData->email)->locale($localteLang)->send(new NewsletterConfirmMail($arr));
      $msg = "email verified successfully";
    } else {
      $msg = "email not verified successfully";
    }
    return view('Frontend.newsletter-confirmation', compact('msg'));
  }
}
