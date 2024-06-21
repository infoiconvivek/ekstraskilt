<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderAddress;
use App\Models\Notification;
use App\Models\UserDetail;
use App\Models\Admin;
use App\Models\Setting;
use Hash;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $data['orders'] = Order::orderBy('id', 'desc')->paginate(15);
        return view('admin.order.index')->with($data);
    }

    public function view($order_id)
    {
        $data['items'] = OrderItem::where(['order_id' => $order_id])->orderBy('id', 'desc')->get();
        $data['address'] = OrderAddress::where(['order_id' => $order_id])->orderBy('id', 'desc')->first();
        return view('admin.order.view')->with($data);
    }
}
