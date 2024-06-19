<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Stripe\StripeClient;
use Stripe\PaymentIntent;
use Stripe\Exception\CardException;
use Exception;
use Artisan;
use PDF;
use File;
use Mail;
use Stripe;

class OrderController extends Controller
{

    public function order(Request $request)
    {
    }

    public function orderConfirm(Request $request)
    {
        $bid = $request->bid;
        $data['order'] = Order::where('id', $bid)->first();
        return view('front.order-confirm')->with($data);
    }

    public function placeOrder(Request $request)
    {
        $user_id = Auth::user()->id;
        $carts = Cart::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        $cartSubTotal = Cart::where('user_id', Auth::user()->id)->sum('price');
        $cartTax = 0;
        $cartTotal =  $cartTax + $cartSubTotal;

        if ($cartTotal < 1) {
            return redirect('cart')->with('msg', 'Cart is empty.');
        }

        $user = User::where('id', Auth::user()->id)->first();
        $detail = UserDetail::where('user_id', Auth::user()->id)->first();


        try {

            Stripe\Stripe::setApiKey("sk_test_51MMRSkSDMBDNfQhDT8LZV7gwgrnVmKQYAwH6moDRaihsaZsZiCPkwuyBVkWm5j2Y0B7unryCn0stWBVmLGAIbfPO00vPyhTiuy");
            $customer = Stripe\Customer::create(array(
                "address" => [
                    "line1" => 'Noida UP',
                    "postal_code" =>  '201301',
                    "city" => 'Noida',
                    "state" => 'UP',
                    "country" => 'India',
                ],

                "email" => Auth::user()->email,
                "name" => 'Gaurav Sharma',
                "source" => $request->stripeToken

            ));

            $stripe = new StripeClient(
                'sk_test_51MMRSkSDMBDNfQhDT8LZV7gwgrnVmKQYAwH6moDRaihsaZsZiCPkwuyBVkWm5j2Y0B7unryCn0stWBVmLGAIbfPO00vPyhTiuy'
            );

           

            // $intent = Stripe\PaymentIntent::create([
            //     'customer' => $customer->id,
            //     'setup_future_usage' => 'off_session',
            //     'amount' => $cartTotal,
            //     'currency' => 'usd',
            //     'automatic_payment_methods' => [
            //       'enabled' => 'true',
            //     ],
            //   ]);



            // Create a product over stripe
            $product_detail = $stripe->products->create([
                'name' => 'test product',
            ]);
            // create prices for the product
            $product_id = $product_detail->id;

            $yearly_price = $stripe->prices->create([
                'unit_amount' => $cartTotal * 100,
                'currency' => 'usd',
                'recurring' => ['interval' => 'year'],
                'product' => $product_id,
            ]);


            $subscription = $stripe->subscriptions->create([
                'customer' => $customer->id,
                'items' => [
                    ['price' => $yearly_price->id],
                ],
            ]);

            $invoice = $stripe->invoices->create([
                'customer' => $customer->id,
            ]);

        //    $finalizeInvoice = $stripe->invoices->finalizeInvoice(
        //     $invoice->id,
        //         []
        //       );
          
           $invoice_pay = $stripe->invoices->pay(
                $invoice->id,
                []
            );

            //dd($invoice_pay);
        } catch (\Exception $e) {
            ///dd($e);
            return redirect('checkout')->with('msg', $e->getMessage());
        }


        /////////// stripe payment end///////////////

        $order = new Order();
        $order->user_id = $user_id;
        $order->currency_code = 'USD';
        $order->amount = $cartTotal;
        $order->save();

        $order_id = $order->id;
        foreach ($carts as $cart) {
            $orderItem = new OrderItem();
            $orderItem->user_id = $user_id;
            $orderItem->order_id = $order_id;
            $orderItem->product_id = $cart->product_id;
            $orderItem->category_id = $cart->category_id;
            $orderItem->quantity = $cart->quantity;
            $orderItem->price = $cart->price;
            $orderItem->is_renewal = $cart->is_renewal;
            $orderItem->save();
        }

        $address = new OrderAddress();
        $address->user_id = $user_id;
        $address->order_id = $order_id;
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->email = $request->email;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->country = $request->country;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->zipcode = $request->zipcode;
        $address->save();

        $payment = new OrderPayment();
        $payment->user_id = $user_id;
        $payment->order_id = $order_id;
        $payment->amount = $cartTotal;
        $payment->currency = 'USD';
        $payment->status = 0;
        $payment->save();


        $data['order'] = Order::where('id', $order_id)->first();
        $delete_cart = Cart::where('user_id', $user_id)->delete();
        return view('front.order-confirm')->with($data);
    }

    public function checkout(Request $request)
    {
        $user_id = 1;
        $data['countries'] = Country::orderBy('name', 'asc')->get();
        $data['user'] = User::where('id', $user_id)->first();
        $data['details'] = UserDetail::where('user_id', $user_id)->first();
        $data['carts'] = Cart::where('user_id', $user_id)->orderBy('id', 'desc')->get();
        $data['cartSubTotal'] = Cart::where('user_id', $user_id)->sum('price');
        $data['cartTax'] = 0;
        $data['cartTotal'] =  $data['cartSubTotal'] + $data['cartTax'];

        // if ($data['cartTotal'] < 1) {
        //     return redirect('cart')->with('msg', 'Cart is empty.');
        // }
        return view('front.checkout')->with($data);
    }
}
