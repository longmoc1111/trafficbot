<?php

namespace App\Http\Controllers;
use App;
use App\Mail\ActivationMail;
use File;
use Illuminate\Support\Facades\Mail;
use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Str;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\VarDumper\Caster\RedisCaster;
use Validator;



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
        // if (!$check) {
        //     return back();
        // }
        if (!$check) {
            return redirect()->back()->with("err_login", "Email chưa được đăng ký !");
        }
        if ($check->status != "active") {
            return redirect()->route("login")->with("err_login", "Tài khoản chưa được kích hoạt !");
        }

        $credentials = $request->only("email", "password");
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role_User->roleName == "admin") {
                return redirect()->route("admintrafficbot.dashboard");
            } elseif ($user->role_User->roleName == "user") {
                return redirect()->route("userpage.home");
            } else {
                return abort(404);
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
        $oldUser = User::where("email", $request->email)->first();
        if ($oldUser && $oldUser->status != "active") {
            $hours = $oldUser->created_at->diffInHours(now());
            if ($hours > 24) {
                $oldUser->delete();
            }
        }
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
            return redirect()->route("login")->with("register_success", "Tạo tài khoản thành công<br>kiểm tra email để kích họat tài khoản của bạn !");
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
        $currentAccount = Auth::user()->userID;
        $accounts = User::where("userID", "!=" , $currentAccount)->orderBy("created_at", "ASC")->paginate(10);
        $roles = Role::get();
        return view("admin.accountManagement.listAccount", compact("accounts", "roles"));
    }
    public function createAccount(Request $request)
    {
        // dd($request->all());
        $newFileName = "";
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
        if ($validate["password"] != $validate["confirmPassword"]) {
            return back()->withErrors(["confirmPassword" => "Mật khẩu xác nhận không trùng khớp !"]);
        }
        if ($request->hasFile("avatar")) {
            $file = $request->file("avatar");
            $fileNameWithoutExt = "user";
            $fileNameExt = $file->getClientOriginalExtension();
            $newFileName = $fileNameWithoutExt . "_" . time() . "." . $fileNameExt;
            $file->move(storage_path("app/public/uploads/avatar"), $newFileName);
            $validate["avatar"] = $newFileName;
        }

        $token = Str::random(64);
        $user = User::create([
            "name" => $validate["name"],
            "email" => $validate["email"],
            "password" => Hash::make($validate["password"]),
            "roleID" => $validate["roleID"],
            "avatar" =>  $validate["avatar"],
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
        if ($request->hasFile("avatar")) {

            if ($request->get("oldAvatar")) {
                $oldfile = storage_path("app/public/uploads/avatar/" . $request->get("oldAvatar"));
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }
            $file = $request->file("avatar");
            $fileNameWithoutExt = "user";
            $fileNameExt = $file->getClientOriginalExtension();
            $newFileName = $fileNameWithoutExt . "_" . time() . "." . $fileNameExt;
            $file->move(storage_path("app/public/uploads/avatar"), $newFileName);
            $validate["avatar"] = $newFileName;
        }
        if (!empty($request->get("password"))) {
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
                if ($validate["status"] == "active") {
                    $user->update([
                        "name" => $validate["name"],
                        "email" => $validate["email"],
                        "roleID" => $validate["roleID"],
                        "password" => Hash::make($validate["password"]),
                        "avatar" => $validate["avatar"],
                        "status" => $validate["status"],
                        "activation_token" => null,
                    ]);
                } else {
                    $user->update([
                        "name" => $validate["name"],
                        "email" => $validate["email"],
                        "roleID" => $validate["roleID"],
                        "avatar" => $validate["avatar"],
                        "password" => Hash::make($validate["password"]),
                        "status" => $validate["status"],
                    ]);
                }

                return redirect()->route("admintrafficbot.listaccount")->with("update_success", "tài khoản được cập nhật thành công!");
            } else {
                return redirect()->route("admintrafficbot.listaccount")->with("update_success", "đã có lỗi xảy ra, vui lòng cập nhật sau!");

            }

        } else {
            $user = User::find($ID);
            if ($user) {
                if ($validate["status"] == "active") {
                    $user->update([
                        "name" => $validate["name"],
                        "email" => $validate["email"],
                        "roleID" => $validate["roleID"],
                        "status" => $validate["status"],
                        "avatar" => $validate["avatar"],
                        "activation_token" => null,
                    ]);
                } else {
                    $user->update([
                        "name" => $validate["name"],
                        "email" => $validate["email"],
                        "roleID" => $validate["roleID"],
                        "status" => $validate["status"],
                        "avatar" => $validate["avatar"],
                    ]);
                }


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
            $results = $user->result_User()->get();
            foreach ($results as $result) {
                $result->update([
                    "userID" => null,
                ]);
            }
            $user->delete();
            return redirect()->route("admintrafficbot.listaccount")->with("delete_success", "Xóa tài khoản thành công!");
        } else {
            return redirect()->route("admintrafficbot.listaccount")->with("delete_fails", "Xóa không thành công, vui lòng thử lại sau!");

        }
    }
    //end quản lý tài khoản

    function changePassword($ID, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "currentPassword" => "required",
            "newPassword" => "required|min:6",
            "newPasswordConfirm" => "required|same:newPassword"
        ], [
            "currentPassword.required" => "vui lòng điền mật khẩu hiện tại!",
            "newPassword.required" => "vui lòng điền mật khẩu mới!",
            "newPassword.min" => "Mật khẩu chứa ít nhất 6 ký tự!",
            "newPasswordConfirm.required" => "vui lòng điền mật khẩu xác nhận!",
            "newPasswordConfirm.same" => "Mật khẩu xác nhận không trùng khớp!",
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->with("active_tab", "account-change-password");
        }
        $user = User::find($ID);
        if (!Hash::check($request->currentPassword, $user->password)) {
            return back()->withErrors(["current_password" => "Mật khẩu cũ không chính xác!"])
                ->with("active_tab", "account-change-password");
        }
        $user->password = Hash::make($request->newPassword);
        $user->save();
        if ($user) {
            return redirect()->route("userpage.profile", ["ID" => $user->userID])->with("change_succes", "Thay đổi mật khẩu thành công!");
        } else {
            return redirect()->route("userpage.profile", ["ID" => $user->userID])->with("change_fails", "Thay đổi mật khẩu thành công!");

        }

    }
    public function updateProfile($ID, Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "name" => "required",
            ],
            [
                "name.required" => "Vui lòng nhập tên của bạn!",
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator, "update_profile");
        }
        $datas = $validator->validated();
        if ($request->hasFile("avatar")) {
            if ($request->get("oldAvatar")) {
                $oldAvatar = storage_path("app/public/uploads/avatar/" . $request->get("oldAvatar"));
                if (File::exists($oldAvatar)) {
                    File::delete($oldAvatar);
                }
            }
            $file = $request->file("avatar");
            $fileNameWithoutExt = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileNameExt = $file->getClientOriginalExtension();
            $newFileName = $fileNameWithoutExt . "_" . time() . "." . $fileNameExt;
            $file->move(storage_path("app/public/uploads/avatar"), $newFileName);
            $datas["avatar"] = $newFileName;
        }

        $user = User::find($ID);
        if ($user) {
            $user->update($datas);
            return redirect()->route("userpage.profile", ["ID" => $user->userID])->with("update_profile_success", "Cập nhật thông tin thành công!");
        } else {
            return redirect()->route("userpage.profile", ["ID" => $user->userID])->with("update_profile_fails", "Cập nhật thông tin thất bại!");

        }
      

    }
      public function updateProfileAdmin($ID, Request $request){
             $validator = Validator::make(
            $request->all(),
            [
                "name" => "required",
            ],
            [
                "name.required" => "Vui lòng nhập tên của bạn!",
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator, "update_profile");
        }
        $datas = $validator->validated();
        if ($request->hasFile("avatar")) {
            if ($request->get("oldAvatar")) {
                $oldAvatar = storage_path("app/public/uploads/avatar/" . $request->get("oldAvatar"));
                if (File::exists($oldAvatar)) {
                    File::delete($oldAvatar);
                }
            }
            $file = $request->file("avatar");
            $fileNameWithoutExt = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileNameExt = $file->getClientOriginalExtension();
            $newFileName = $fileNameWithoutExt . "_" . time() . "." . $fileNameExt;
            $file->move(storage_path("app/public/uploads/avatar"), $newFileName);
            $datas["avatar"] = $newFileName;
        }

        $user = User::find($ID);
        if ($user) {
            $user->update($datas);
            return redirect()->route("admintrafficbot.dashboard")->with("update_profile_success", "Cập nhật thông tin thành công!");
        } else {
            return redirect()->route("admintrafficbot.dashboard")->with("update_profile_fails", "Cập nhật thông tin thất bại!");

        }
        }




}
