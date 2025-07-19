<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

route::middleware("guest")->group(function () {
    route::get("/login", [AuthController::class, "login"])->name("login");
    route::post("/login", [AuthController::class, "loginPost"])->name("login.post");

    route::get("/register", [AuthController::class, "register"])->name("register");
    route::post("/register", [AuthController::class, "registerPost"])->name("register.post");

    route::get("/forgot_password", [ForgotPasswordController::class, "forgotPassword"])->name("password.request");
    route::post("/forgot_password", [ForgotPasswordController::class, "senResetLink"])->name("password.email");
    route::get("/reset_password/{token}", [ForgotPasswordController::class, "resetPassword"])->name("password.reset");
    route::post("/reset_password", [ForgotPasswordController::class, "updatePassword"])->name("password.update");
});
route::post("/change-password/{ID}", [AuthController::class, "changePassword"])->name("password.change");
route::put("/profile/update/{ID}", [AuthController::class, "updateProfile"])->name("profile.update");


route::post("/logout", [AuthController::class, "logoutPost"])->name("logout.post");
//mail
route::get("activate/{token}", [AuthController::class, "activateMail"])->name("activate.Mail");

route::middleware("admin")->controller(AuthController::class)->prefix("admintrafficbot")->name("admintrafficbot")->group(function () {
    route::get("/account", "listAccount")->name(".listaccount");
    route::post("/account/create", "createAccount")->name(".account.create");
    route::post("/account/update/{ID}", "updateAccount")->name(".account.update");
    route::delete("/account/delete/{ID}", "deleteAccount")->name(".account.delete");
    route::put("/profile/update/{ID}","updateProfileAdmin")->name(".profile.update");



});