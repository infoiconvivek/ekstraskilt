<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Nonstandard\UuidV6;
use stdClass;

class WishlistController extends Controller
{

   public function addToWishlist(Request $request)
    {
        $wishlist = Session::get('wishlist', []);
        $id = $request->product_id;
        $product = Product::where(['id' => $id , 'status' => 1])->first();

        $item = new stdClass();
        $item->product_id = $product->id;
        $item->title = $product->title;
        $item->image = $product->image;
        $item->brand_logo = $product->brand_logo;
        $item->slug = $product->slug;
        $item->price = $product->price;
        $item->sell_price = $product->sell_price;
        $item->quantity = $request->quantity ? $request->quantity : 1;
        $item->id = UuidV6::uuid6();
        $wishlist[] = $item;
        Session::put('wishlist', $wishlist);
        return redirect()->back()->with('msg', 'Product has been added to your wishlist.');
    }


    public function wishlist(Request $request)
    {
        $data['wishlists'] = Session::get('wishlist', []);
        return view('front.wishlist')->with($data);
    }

    public function deleteWishlist(Request $request,$product_id)
    {
        $wishlist = Session::get('wishlist', []);
        $filter = [];
        if (!$product_id) {
            return response()->json(['message' => 'Product id is required.'], 400);
        }
        foreach ($wishlist as $list) {
            if ($list->product_id != $product_id) {
                $filter[] = $list;
            }
        }
        Session::put('wishlist', $filter);
        return redirect()->back()->with('msg', 'Product deleted from wishlist.');
    }

}
