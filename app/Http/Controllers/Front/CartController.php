<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Product;
use App\Models\Cart;
use App\Interfaces\HotelRepositoryInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Nonstandard\UuidV6;
use stdClass;

class CartController extends Controller
{

    public function addToCart(Request $request)
    {
        $cart = Session::get('cart', []);
        $id = $request->product_id;
        $product = Product::where(['id' => $id , 'status' => 1])->first();

        $item = new stdClass();
        $item->product_id = $product->id;
        $item->title = $product->title;
        $item->image = 'storage/products/'.$product->thumbnail;
        $item->brand_logo = $product->brand_logo;
        $item->slug = $product->slug;
        $item->price = $product->price;
        $item->quantity = $request->quantity ? $request->quantity : 1;
        $item->id = UuidV6::uuid6();
        $cart[] = $item;
        Session::put('cart', $cart);
        return redirect('cart')->with('msg', 'Product has been added to your cart.');
    }


    public function cart(Request $request)
    {
        $data['carts'] = Session::get('cart', []);
        $subtotal = 0;
        foreach($data['carts'] as $cart_data)
        {
             $subtotal = $subtotal + $cart_data->price;
        }

        $data['cartSubTotal'] = $subtotal;
        $data['cartTax'] = 0;
        $data['cartTotal'] =  $data['cartSubTotal'] + $data['cartTax'];
        return view('front.cart')->with($data);
    }

    public function deleteCart(Request $request,$product_id)
    {
        //dd($offer_id);
        $cart = Session::get('cart', []);
        ///dd($cart);
        $filter = [];
        if (!$product_id) {
            return response()->json(['message' => 'Product id is required.'], 400);
        }
        foreach ($cart as $list) {
            if ($list->product_id != $product_id) {
                $filter[] = $list;
            }
        }
        Session::put('cart', $filter);
        return redirect('cart')->with('msg', 'Product deleted from cart.');
    }
}
