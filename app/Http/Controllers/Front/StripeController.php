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
use Illuminate\Support\Str;
use Stripe\StripeClient;
use Stripe\Exception\CardException;
use Exception;
use Artisan;
use Mail;
use Auth;
use Stripe;

class StripeController extends Controller
{

    public function stripePage(Request $request)
    {
        return view('front.stripe');
    }

    public function stripePay(Request $request)
    {
        Stripe\Stripe::setApiKey("sk_test_51NVTlPHGmofNXC0OI5ovmDqc5UiPsxcJi0Erilu0FwFuHLhLntNBYsevq1rdtial2SDB8abpm7WJwbq8fTZFBG2H00gbxLdNzW");
        $customer = Stripe\Customer::create(array(
            "address" => [
                "line1" => 'Noida UP',
                "postal_code" =>  '201301',
                "city" => 'Noida',
                "state" => 'UP',
                "country" => 'India',
            ],

            "email" => 'gaurav@yopmail.com',
            "name" => 'Gaurav Sharma',
            "source" => $request->stripeToken

        ));

        try {

            $charge = Stripe\Charge::create([
                "amount" => (45) * 100,
                "currency" => 'CHF',
                "customer" => $customer->id,
                "description" => "stripe payment for dubai travels.",
                "shipping" => [
                    "name" => 'Gaurav Sharma',
                    "address" => [
                        "line1" => 'Noida Up',
                        "postal_code" => '201301',
                        "city" => 'Noida',
                        "state" => 'UP',
                        "country" => 'India',
                    ],

                ]

            ]);
        } catch (\Stripe\Exception\CardException $e) {
            return redirect()->back()->with('errMsg', $e->getMessage());
        } catch (\Stripe\Exception\RateLimitException $e) {
            return redirect()->back()->with('errMsg', $e->getMessage());
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return redirect()->back()->with('errMsg', $e->getMessage());
        } catch (\Stripe\Exception\AuthenticationException $e) {
            return redirect()->back()->with('errMsg', $e->getMessage());
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            return redirect()->back()->with('errMsg', $e->getMessage());
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return redirect()->back()->with('errMsg', $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->with('errMsg', $e->getMessage());
        }

        $msg = 'Payment successful';
        return redirect('success-stripe-payment?reff=99')->with($msg);
    }

    public function successStripePayment(Request $request)
    {
        dd('paid');
        return view('front.success-stripe-payment');
    }
}
