<?php

namespace App\Models;

use Exception;
use Twilio\Rest\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserOTP extends Model
{
    use HasFactory;
    protected $table = 'user_otps';

    protected $fillable = [
        'user_id',
        'mobile_otp',
        'expire_at',
    ];


    public function sendSMS($receiverNumber){
        $message='Login OTP is'.$this->mobile_otp;
        try {
            $accoun_id=getenv("TWILIO_SID");
            $auth_token=getenv("TWILIO_TOKEN");
            $twilio_number=getenv("TWILIO_FROM");
            $client=new Client($accoun_id,$auth_token );
            $client->messages->create($receiverNumber,[
                'from'=>$twilio_number,
                'body'=>$message
            ]);
            info('SMS send Successfully');
        } catch (\Exception $th) {
            info('the error '.$th->getMessage());

        }

    }
}
