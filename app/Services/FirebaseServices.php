<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Device;

class FirebaseServices {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function sendNotification($request)
    {
        
        
         $url = 'https://fcm.googleapis.com/fcm/send';

         if($request['user_id'] != '')
         {
            $FcmToken = Device::where('user_id',$request['user_id'])->whereNotNull('token')->pluck('token')->all();
         } else
         {
            $FcmToken = Device::whereNotNull('token')->pluck('token')->all();
         }
         
        /// $FcmToken = [0 => "cbgiRBszBEZMtSjuEN8MNv:APA91bFkDd9toyn0FPZCkDYuniPPUxuEpMdc7xNbTWkGDhnPRX640XvL6tNrou1W7-H_L_PGR_JOkxgvWDSgB0DQSdWmiJWj8vUhmkBd1QydtHkqglY_rmH309FU8M3cNB-WFRH7VCQv"];
        // dd($FcmToken);
          
        $serverKey = env('FIREBASE_SERVER_KEY');
  
        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $request['title'],
                "body" => $request['body'],  
            ]
        ];
        $encodedData = json_encode($data);
    
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
        // Close connection
        curl_close($ch);
        // FCM response
    }
    public function updateToken(Request $request){
        try{
            $request->user()->update(['fcm_token'=>$request->token]);
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }
}