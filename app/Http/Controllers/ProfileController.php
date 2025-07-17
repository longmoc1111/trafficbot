<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile($ID)
    {
        $passed = 0;
        $failed = 0;
        $information = Auth::user();
        if ($information && $information->userID == $ID) {
            $resultExam = ExamResult::where("userID", $ID)->paginate(5);
            $statistical = ExamResult::where("userID", $ID)->get();
            
            foreach ($statistical as $result) {
                if ($result->passed == true || $result->passed == 1) {
                    $passed++;
                } else {
                    $failed++;
                }
            } 
            return view("userPage.profile.profile", compact("information", "passed", "failed", "resultExam","statistical"));
        } else {
            return abort(403);
        }
    }
}
