<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use Illuminate\Http\Request;
class DashBoardController extends Controller
{
    public function dashBoard(){
        $results = ExamResult::orderBy("created_at", "ASC")->paginate(10);
        $resutlcharlt = ExamResult::all();
        $allMonths = range(1,12);
        $charData = [];
        foreach($allMonths as $month){
            $monthResult = $resutlcharlt->filter(function($result) use ($month){
                return $result->created_at->month == $month;
            });
            $people = $monthResult->count();
            $passed = $monthResult->where("passed" , 1)->count();
            $notPassed = $monthResult->where("passed" , 0)->count();
            $charData[] = [
                "month"=>$month,
                "people"=>$people,
                "passed"=>$passed,
                "notPassed"=>$notPassed 
            ];

        } 
        return view("admin.dashboardManagement.dashBoard",compact("charData","results"));
    }

}
