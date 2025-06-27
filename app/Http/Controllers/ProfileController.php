<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile($ID){
        $passed = 0;
        $failed = 0;
        $resultExam = ExamResult::where("userID", $ID)->get();
        foreach($resultExam as $result){
            if($result->passed == true || $result->passed == 1){
                $passed++;
            }else{
                $failed++;
            }
        }
        $information = User::find($ID);
        return view("userPage.profile.profile",compact("information", "passed", "failed","resultExam"));
    }
}
