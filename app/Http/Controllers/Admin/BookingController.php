<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Job;
use App\Models\Booking;
use App\Models\UserDetail;
use App\Models\Admin;
use App\Models\Setting;
use Hash;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $data['user_bookings'] = Booking::select('booking.id as booking_id','booking.*','jobs.*','users.*')->leftJoin('jobs','jobs.id','booking.job_id')->leftJoin('users','users.id','booking.user_id')->paginate(15);
        return view('admin.booking.index')->with($data);
    }

    public function view(Request $request)
    {
        $booking_id = $request->booking_id;
        $booking = Booking::select('booking.id as booking_id','booking.*','jobs.*','users.*')->leftJoin('jobs','jobs.id','booking.job_id')->leftJoin('users','users.id','booking.user_id')->where('booking.id',$booking_id)->first();
        return view('admin.booking.view', compact('booking'));
    }
}
