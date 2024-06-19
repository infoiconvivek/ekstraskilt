<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriber;


class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $data['subscribers'] = Subscriber::orderBy('id','desc')->paginate(15);
        return view('admin.subscriber.index')->with($data);
    }

    public function action($type, $id)
    {
        if (!in_array($type, ['view', 'delete']))
        return redirect()->back()->with(['message' => 'Invalid Action']);

        $subscriber = Subscriber::findOrFail($id);

        if ($type == "delete") {
            $delData = Subscriber::where('id', $id)->delete();
            return response()->json(['msg' => 'deleted']);
        }
    
        return abort(404);
    }
}
