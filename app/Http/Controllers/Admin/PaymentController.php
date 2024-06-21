<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Payment;
use App\Models\Notification;
use App\Models\UserDetail;
use App\Models\Admin;
use App\Models\Setting;
use Hash;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $data['payments'] = Payment::orderBy('id', 'desc')->paginate(15);
        return view('admin.payment.index')->with($data);
    }

    public function view($payment_id)
    {
        $data['payment'] = Payment::where(['id' => $payment_id])->first();
        return view('admin.payment.view')->with($data);
    }
}
