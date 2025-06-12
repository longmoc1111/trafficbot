<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Mail;
use Str;

class ForgotPasswordController extends Controller
{
    
    public function forgotPassword(){
        return view("auth.forgotPassword");
    }
    public function senResetLink(Request $request){
        $request->validate([
            "email"=>"required|email|exists:users,email",
        ],
        [
            "email.required"=>"Vui lòng nhập email !",
            "email.email"=>"định dạng không phải email !",
            "email.exists"=>"email chưa được đăng ký tài khoản !",
        ]
    );
    $user = User::where("email",$request->email)->first();
    $token = Password::createToken($user);
    Mail::to($user->email)->send(new ResetPasswordMail($token, $user));

    return back()->with("send_email_success","Liên kết khôi phục mật khẩu đã được gửi đến email của bạn !");
    }
     public function resetPassword(string $token){
        return view("auth.resetPassword",["token"=>$token]);
    }

    public function updatePassword(Request $request){
        $validate = $request->validate([
            "email"=>"required|email|exists:users,email",
            "password"=>"required|min:6",
            "confirmPassword"=>"required",
            "token"=>"required",
        ],
        [
            "email.required"=>"vui lòng điền email !",
            "email.email"=>"Email không đúng định dạng !",
            "email.exists"=>"Email chưa được đăng ký !",
            "password.required"=>"Vui lòng điện mật khẩu mới !",
            "password.min"=>"Mật khẩu tối thiểu 6 ký tự !",
            "confirmPassword.required"=>"Vui lòng điện mật khẩu xác nhận mới !",
            "token"=>"Đã xảy ra lỗi hoặc yêu cầu đặt lại mật khẩu đã hết hạn !"
        ]);
        if($validate["password"] != $validate["confirmPassword"]){
            return back()->withErrors(["confirmPassword"=>"Mật khẩu xác nhận không trùng khớp !"]);
        }
        $status = Password::reset(
            $request->only("email","password","token"),
            function (User $user, string $password){
                $user->forceFill([
                    "password"=>Hash::make($password)
                ])->setRememberToken(Str::random(64));
                $user->save();            
            });
        if($status === Password::PASSWORD_RESET){
            return redirect()->route("login")->with("reset_password_success","mật khẩu của bạn đã được đặt lại thành công !");
        }else{
            return back()->with("reset_password_fail","đã có lỗi xãy ra, đặt lại mật khẩu không thành công !");
        }
    }

}
