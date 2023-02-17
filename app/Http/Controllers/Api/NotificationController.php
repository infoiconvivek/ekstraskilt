<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Mail\ResetUserPasswordMail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Notification;
use Mail;
use DB;

class NotificationController extends Controller
{

    public function notifications(Request $request)
    {
        $user_id = Auth::guard('api')->user()->id;
        $notifications = Notification::where('user_id', 0)->get();

        $response = [
            'success' => true,
            'message' => 'Notifications List',
            'notifications' => $notifications,
        ];

        return response()->json($response, 200);
    }

 
}
