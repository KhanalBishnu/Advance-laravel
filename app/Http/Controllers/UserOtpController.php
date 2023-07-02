<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserOTP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOtpController extends Controller
{
    public function otpLogin(){
        return view('otp.otpLogin');
    }

    public function generate(Request $request){
        $request->validate([
            'mobile_no'=>'required|exists:users,mobile_no'
        ]);
        $userOTP=$this->generateOTP($request->mobile_no);
        $userOTP->sendSMS($request->mobile_no);
        return redirect()->route('otp.verify',[$userOTP->user_id])->with('success','OTP has been send on your Mobile');
    }

    public function generateOTP($mobile_no){
        $user=User::where('mobile_no',$mobile_no)->first();
        $userOTP=UserOTP::where('user_id',$user->id)->latest()->first();
        $now=now();
        if($userOTP && $now->isBefore($userOTP->expire_at)){
            return $userOTP;
        }
        return UserOTP::create([
            'user_id'=>$user->id,
            'mobile_otp'=>rand(123456,999999),
            'expire_at'=>$now->addMinutes(10),
        ]);
        
    }
    public function otpVarify($user_id){
        return view('otp.varfiy_opt',compact('user_id'));
    }
    public function LoginWithOtp(Request $request){
        $request->validate([
            'mobile_otp'=>'required',
            'user_id'=>'required|exists:users,id'
        ]);
        $userOTP=UserOTP::where('user_id',$request->user_id)->where('mobile_otp',$request->mobile_otp)->first();
        $now=now();
        if(!$userOTP){
            return redirect()->back()->with('error','Your OTP is not correct');
        }else if($userOTP && $now->isAfter($userOTP->expire_at)){
            return redirect()->back()->with('error','Your OTP is Expired');
            
        }
        $user=User::whereId($request->user_id)->first();
        if($user){
            $userOTP->update([
                'expire_at'=>now()
            ]);
            Auth::login($user);
            return redirect()->route('home');
        }
        return redirect()->route('otpLogin')->with('error','Your OTP is not Correct');
    }

    public function home(){
        return view('otp.home');
    }
}
