<?php

namespace App\Http\Controllers;
use App;
use App\Mail\ActivationMail;
use Illuminate\Support\Facades\Mail;
use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Str;
use Symfony\Component\VarDumper\Caster\RedisCaster;



class AuthController extends Controller
{

    // login ,register và logout
    public function login()
    {
        return view("auth.login");
    }
    public function loginPost(Request $request)
    {
        $validate = $request->validate([
            "email" => "required",
            "password" => "required",
        ]);
        $check = User::where("email", $validate["email"])->first();
        if (!$check) {
            return back();
        }
        if ($check->status != "active") {
            return redirect()->route("login")->with("err_login", "Tài khoản chưa được kích hoạt !");
        }
        if (!$check) {
            return redirect()->route("login")->with("err_login", "Email chưa được đăng ký !");
        }
        $credentials = $request->only("email", "password");
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role_User->roleName == "admin") {
                return redirect()->route("admintrafficbot.dashboard");
            } elseif ($user->role_User->roleName == "user") {
                return redirect()->route("userpage.home");
            } else {
                dd("co loi");
            }
        } else {
            return redirect()->route("login")->with("err_login", "Thông tin tài khoản hoặc mật khẩu không chính xác !");
        }
    }

    public function register()
    {
        return view("auth.register");
    }
    public function registerPost(Request $request)
    {
        $validate = $request->validate(
            [
                "name" => "required",
                "email" => "required|unique:users,email",
                "password" => "required|min:6",
                "confirmPassword" => "required",
            ],
            [
                "name.required" => "vui lòng điền tên tài khoản !",
                "email.unique" => "Email đã tồn tại !",
                "email.required" => "vui lòng điền email !",
                "password.required" => "vui lòng điền mật khẩu !",
                "password.min" => "mật khẩu tối thiểu 6 ký tự !",
                "confirmPassword.required" => "Vui lòng điềm mật khẩu xác nhận !",

            ]
        );
        if ($validate["password"] != $validate["confirmPassword"]) {
            return back()->withErrors(["confirmPassword" => "Mật khẩu xác nhận không trùng khớp !"]);
        }
        $token = Str::random(64);
        $user = User::create([
            "name" => $validate["name"],
            "email" => $validate["email"],
            "password" => Hash::make($validate["password"]),
            "roleID" => Role::USER,
            "status" => "pending",
            "activation_token" => $token
        ]);
        Mail::to($user->email)->send(new ActivationMail($token, $user));
        if ($user) {
            return redirect()->route("login")->with("register_success", "Tạo tài khoản thành công!<br>kiểm tra email để kích họat tài khoản của bạn !");
        } else {
            return back()->with("register_fail", "Tạo tài khoản thất bại, vui lòng thử lại !");
        }
    }

    public function activateMail($token)
    {
        $user = User::where("activation_token", $token)->first();
        if ($user) {
            $user->status = "active";
            $user->activation_token = null;
            $user->save();
            return redirect("login")->with("active_success", "Tài khoản của bạn đã được thành công !");
        } else {
            return redirect("login")->with("active_fail", "Kích hoạt tài khoản thất bại !");

        }
    }

    public function logoutPost()
    {
        Auth::logout();
        return redirect()->route("userpage.home");
    }
    //end login, register va logout



    //quản lý tài khoản 

    public function listAccount()
    {
        $accounts = User::get();
        $roles = Role::get();
        return view("admin.accountManagement.listAccount", compact("accounts", "roles"));
    }
    public function createAccount(Request $request)
    {
        // dd($request->all());
        $validate = $request->validate(
            [
                "name" => "required",
                "email" => "required|unique:users,email",
                "password" => "required|min:6",
                "confirmPassword" => "required",
                "roleID" => "required"
            ],
            [
                "name.required" => "vui lòng điền tên tài khoản !",
                "email.unique" => "Email đã tồn tại !",
                "email.required" => "vui lòng điền email !",
                "password.required" => "vui lòng điền mật khẩu !",
                "password.min" => "mật khẩu tối thiểu 6 ký tự !",
                "confirmPassword.required" => "Vui lòng điềm mật khẩu xác nhận !",
                "roleID.required" => "vui lòng phân quyền cho tài khoản!"

            ]
        );
        if ($request->hasFile("avatar")) {
            $file = $request->file("avatar");
            $fileNameWithoutExt = "user";
            $fileNameExt = $file->getClientOriginalExtension();
            $newFileName = $fileNameWithoutExt . "_" . time() . "." . $fileNameExt;
            $file->move(public_path("assets/adminPage/avatar_user"), $newFileName);
            $validate["avatar"] = $newFileName;
        }
        if ($validate["password"] != $validate["confirmPassword"]) {
            return back()->withErrors(["confirmPassword" => "Mật khẩu xác nhận không trùng khớp !"]);
        }
        $token = Str::random(64);
        $user = User::create([
            "name" => $validate["name"],
            "email" => $validate["email"],
            "password" => Hash::make($validate["password"]),
            "roleID" => $validate["roleID"],
            "status" => "pending",
            "activation_token" => $token
        ]);
        Mail::to($user->email)->send(new ActivationMail($token, $user));
        if ($user) {
            return redirect()->route("admintrafficbot.listaccount")->with("create_success", "tài khoản được tạo thành công, vui long kích hoạt!");
        } else {
            return redirect()->route("admintrafficbot.listaccount")->with("craeate_fails", "Tạo tài khoản không thành công, vui lòng thử lại sau!")
            ;
        }
    }

    public function updateAccount($ID, Request $request)
    {
        // dd($request->all());
        $validate = $request->validate(
            [
                "name" => "required",
                "email" => "required",
                "roleID" => "required",
                "status" => "required"
            ],
            [
                "name.required" => "vui lòng điền tên tài khoản !",
                "email.unique" => "Email đã tồn tại !",
                "email.required" => "vui lòng điền email !",
                "roleID.required" => "vui lòng phân quyền cho tài khoản!",
                "status.required" => "vui lòng xét trạng thái cho tài khoản!"
            ]
        );
        if (!empty($request->get("password"))) {
            echo "123243";
            $validate = $request->validate([
                "password" => "min:6",
                "confirmPassword" => "required"
            ], [
                "password.min" => "mật khẩu tối thiểu 6 ký tự !",
                "confirmPassword.required" => "Vui lòng điền mật khẩu xác nhận!",
            ]);
            if ($validate["password"] != $validate["confirmPassword"]) {
                return back()->withErrors(["confirmPassword" => "Mật khẩu xác nhận không trùng khớp !"]);
            }

            $user = User::find($ID);
            if ($user) {
                $user->update([
                    "name" => $validate["name"],
                    "email" => $validate["email"],
                    "roleID" => $validate["roleID"],
                    "password" => Hash::make($validate["password"]),
                    "status" => $validate["status"],
                    // "activation_token" => $token
                ]);
                return redirect()->route("admintrafficbot.listaccount")->with("update_success", "tài khoản được cập nhật thành công!");
            } else {
                return redirect()->route("admintrafficbot.listaccount")->with("update_success", "đã có lỗi xảy ra, vui lòng cập nhật sau!");

            }

        } else {
            $user = User::find($ID);
            if ($user) {
                $user->update([
                    "name" => $validate["name"],
                    "email" => $validate["email"],
                    "roleID" => $validate["roleID"],
                    "status" => $validate["status"],

                ]);

                return redirect()->route("admintrafficbot.listaccount")->with("update_success", "tài khoản được cập nhật thành công!");
            } else {
                return redirect()->route("admintrafficbot.listaccount")->with("update_success", "đã có lỗi xảy ra, vui lòng cập nhật sau!");

            }
        }

    }


    public function deleteAccount($ID)
    {
        $user = User::find($ID);
        if ($user) {
            $user->delete();
            return redirect()->route("admintrafficbot.listaccount")->with("delete_success", "Xóa tài khoản thành công!");
        } else {
            return redirect()->route("admintrafficbot.listaccount")->with("delete_fails", "Xóa không thành công, vui lòng thử lại sau!");

        }
    }
    //end quản lý tài khoản




}
