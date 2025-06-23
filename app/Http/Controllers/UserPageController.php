<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use App\Models\Question;
use App\Models\QuestionCategory;
use Auth;
use Illuminate\Http\Request;
use App\Models\LicenseType;
use App\Models\ExamSet;
use App\Models\Answer;
use App\Models\SignageType;



class UserPageController extends Controller
{
    public function homePage()
    {
        $chapter = QuestionCategory::get()->first();
        $signage = SignageType::get()->first();
        return view("userPage.home.home", compact("chapter", "signage"));
    }


    public function signages($SignageTypeID)
    {
        $signagesType = SignageType::find($SignageTypeID);
        return view("userPage.trafficSigns.signages", compact("signagesType"));
    }



}
