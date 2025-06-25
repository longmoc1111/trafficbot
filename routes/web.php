<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\QuestionCategoryController;
use App\Http\Controllers\QuizzController;
use App\Http\Controllers\SignageController;
use App\Http\Controllers\UserPageController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\LicenseTypeController;
use App\Http\Controllers\ExamSetController;

use App\Models\ExamSet;
use App\Models\LicenseType;
use Illuminate\Support\Facades\Route;


Route::middleware("admin")->controller(DashBoardController::class)->prefix("admintrafficbot")->name("admintrafficbot")->group(function(){
        route::get("/dashboard", "dashBoard")->name(".dashboard");

}); 

Route::middleware("admin")->controller(QuestionController::class)->prefix("admintrafficbot")->name("admintrafficbot")->group(function(){
    Route::get("/question", "listQuestion")->name(".question");
    Route::get("/question/serach", "serachQuestion")->name(".question.search");
    Route::get("/question/create","createQuestion")->name(".question.create");
    Route::post("question/store","storeQuestion")->name(".question.store");
    Route::delete("question/delete/{QuestionID}","deleteQuestion")->name(".question.delete");
    Route::get("question/edit/{QuestionID}","editQuestion")->name(".question.edit");
    Route::put("question/update/{QuestionID}","updateQuestion")->name(".question.update");
    Route::get("question/detail/{QuestionID}","detailQuestion")->name(".question.detail");
    Route::get("/examset/show/create_question/{ExamSetID}","createQuestion_ExamSet")->name(".examset_question.create");
    Route::post("/examset/show/store_question/{ExamSetID}","storeQuestion_ExamSet")->name(".examset_question.store");   
    Route::get("question/show/edit_question/{QuestionID}","editQuestion")->name(".question.edit_question");
    

});

Route::middleware("admin")->controller(QuestionCategoryController::class)->prefix("admintrafficbot")->name("admintrafficbot")->group(function(){
     route::get("question/category","questionCategory")->name(".question.category");
     route::get("question/category/search","searchCategory")->name(".question.category.search");
     route::get("question/category/create","createCategory")->name(".question.createcategory");
     route::post("question/category/store","storeCategory")->name(".question.storecategory");
     route::post("question/category/update/{ID}","updateCategory")->name(".question.updatecategory");
     route::delete("question/category/delete/{ID}","deleteCategory")->name(".question.deletecategory");


});
Route::middleware("admin")->controller(SignageController::class)->prefix("admintrafficbot")->name("admintrafficbot")->group(function(){
    Route::get("/listsignage","listSignage")->name(".listsignage");
});
Route::middleware("admin")->controller(LicenseTypeController::class)->prefix("admintrafficbot")->name("admintrafficbot")->group(function(){
    Route::get("/license/list", "listLicenseType")->name(".listlicensetype");
    Route::get("/license/list/create","createLicenseType")->name(".licensetype.create");
    Route::get("/license/list/edit/{ID}","editLicenseType")->name(".licensetype.edit");
    Route::post("/license/list/store","storeLicenseType")->name(".licensetype.store");
    Route::delete("/license/list/delete/{ID}","deleteLicenseType")->name(".licensetype.delete");
    Route::put("/license/list/update/{ID}","updateLicenseType")->name(".licensetype.update");



});
Route::middleware("admin")->controller(ExamSetController::class)->prefix("admintrafficbot")->name("admintrafficbot")->group(function(){
    Route::get("/exam_set", "listExamSet")->name(".examset");
    Route::get("/exam_set/add/{ID}",action: "createExamSet")->name(".examset.create");
    Route::post("/exam_set/store","storeExamSet")->name(".examset.store");
    Route::delete("/exam_set/delete/{ExamSetID}","deleteExamSet")->name(".examset.delete");
    Route::get("/exam_set/edit/{ExamSetID}","editExamSet")->name(".examset.edit");
    Route::put("/exam_set/update/{ExamSetID}","updateExamSet")->name(".examset.update");
    Route::get("/exam_set/show/{ExamSetID}","showExamSet")->name(".examset.show");
});

Route::middleware("admin")->controller(ChatBotController::class)->prefix("admintrafficbot")->name("admintrafficbot")->group(function(){
   route::get("/chat_bot","dataList")->name(".chatbot");
   route::post("/chat_bot/store","storeChatBot")->name(".chatbot.store");
   route::post("/chat_bot/update/{ID}","updateChatBot")->name(".chatbot.update");
   route::delete("/churi: at_bot/delete/{ID}","deleteChatBot")->name(".chatbot.delete");



});


route::controller(UserPageController::class)->name("userpage")->group(function() {
    route::get("/","homePage")->name(".home");
    route::get("/signages/{SignageTypeID}","signages")->name(".signages");


});


route::controller(QuizzController::class)->name("userpage")->group(function() {
    route::get("/practice-test", "practiceTest")->name(".practice.test");
    route::get("/practice-test/{licenseID}", "getExam")->name("practice.getexam");
    route::get("/practice-info/{licenseID}", "getInfo")->name("practice.getinfo");
    route::get("/quiz-practice/{LicenseTypeID}","PracticeExam")->name(".practiceExam");
    route::post("/quiz-practice/start/","PracticeStart")->name(".practiceStart");
    route::get("/quiz-practice/start-random/{licenseID}","PracticeStartRandom")->name(".practice.start.random");
    route::post("/quiz-practice/finish/{licenseTypeID}","PracticeFinish")->name(".practicefinish");

    route::get("/quiz-chapters/{ID}","chapters")->name(".chapters");

    route::get("/quiz-collection/250-A1/{ID}","collectionA")->name(".collectionA");
    route::get("/quiz-collection/300-B1/{ID}","collectionBOne")->name(".collectionBone");

});


 


route::middleware("admin")->controller(SignageController::class)->prefix("admintrafficbot")->name("admintrafficbot")->group(function(){
      route::get("/signages/type/list","listSignageTypes")->name(".listsignagetypes");
      route::get("/signages/type/list/search","searchSignageTypes")->name(".signagetypes.sarch");
      route::get("/signages/type/list/create","createSignageTypes")->name(".signagestype.create");
      route::post("/signages/type/list/store","storeSignageTypes")->name(".signagestype.store");
       route::post("/signages/type/list/update/{ID}","updateSignageTypes")->name(".signagestype.update");
       route::delete("/signages/type/list/delete/{ID}","deleteSignageTypes")->name(".signagestype.delete");


      route::get("/signages/list","listSignages")->name(".listsignages");
      route::get("/signages/list/search","searchSignage")->name(".signage.sarch");
      route::get("/signages/list/create","createSignages")->name(".signages.create");
      route::post("/signages/list/store","storeSignages")->name(".signages.store");
      route::post("/signages/list/update{ID}","updateSignages")->name(".signages.update");
      route::delete("/signages/list/delete/{ID}","deleteSignages")->name(".signages.delete");
});

