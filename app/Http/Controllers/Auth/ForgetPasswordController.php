<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\{ForgetPasswordRequest,ResetPasswordRequest};
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ForgetPasswordController extends Controller
{
    public function otpSend(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }
            $email = $validator->validated()['email'];
            $otp = mt_rand(1000, 9999);
            Cache::put('password_reset_' . $email, $otp, now()->addMinutes(10));
            Mail::to($email)->send(new OtpMail($otp));
    
            return response()->json(['success' => 'OTP sent successfully']);
        }catch(\Exception $e){
            return response()->json(['error'=> $e->getMessage()],302);
        }
    }
    public function reset(ForgetPasswordRequest $request){
        $otp = $request->input('otp');
        $cachedOtp = Cache::get('password_reset_' . $request->input('email'));
        // dd($cachedOtp);
        if (!$cachedOtp || $cachedOtp != $otp) {
            return response()->json(['error' => 'Invalid OTP']);
        }
        return response()->json(['success' => 'OTP Verified']);     
    }
    public function resetPassword(ResetPasswordRequest $request){
            $data = $request->only('email', 'password', 'password_confirmation');
            $user = User::where('email', $data['email'])->first();
            if($user){
                $user->forceFill([
                    'password' => Hash::make($data['password']),
                ])->setRememberToken(Str::random(60));
     
                $user->save();
            }else{
                return response()->json(['error'=>'There is no user exisis on the given email']);
            }
                // event(new PasswordReset($user));
        if ($user) {
            return response()->json(['success'=> 'Your password has been successfully reset.']);
        } else {
            return response()->json(['error'=> $user]);
        }
    }
}
