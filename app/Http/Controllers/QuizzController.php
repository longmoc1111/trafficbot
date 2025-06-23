<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\QuestionCategory;
use Illuminate\Http\Request;
use App\Models\LicenseType;
use App\Models\ExamSet;


class QuizzController extends Controller
{
        public function practiceExam(string $id)
    {

        $license = LicenseType::find($id);
        $licenseName = $license->LicenseTypeName;
        if ($licenseName) {
            $wordA = explode(" ", $licenseName);
            $lastWordA = end($wordA);
        }

        $examSets = $license->examset_LicenseType;
        return view("userPage.quiz.practiceExam", compact("examSets", "license", "lastWordA"));
    }
    public function practiceTest(){
         $licenses = LicenseType::all();
        return view("userPage.quiz.practiceTest",compact("licenses"));
    }

    public function getInfo($licenseID){
        $license = LicenseType::with("questionCategory_LicenseType")->find($licenseID);
        $dataInfo = [];
        if(!$license){
            return response()->json(["error" => "Không tìm thấy dữ liệu!"], 404);
        }
        $dataLicense = [
            "duration" => $license->LicenseTypeDuration,
            "name" => $license->LicenseTypeName,
            "passcount" => $license->LicenseTypePassCount,
            "quantity" => $license->LicenseTypeQuantity

        ];
        $dataCategory = $license->questionCategory_LicenseType->map(function($category){
            return [
                "name" => $category->CategoryName,
                "quantity" => $category->pivot->Quantity
            ];
        });
        return response()->json([
            "dataLicense" => $dataLicense,
            "dataCategory" => $dataCategory
         ]);
    }

    public function getExam($licensenID){
        $license = LicenseType::with("examset_LicenseType")->find($licensenID);
        if(!$license){
            return response()->json(["error" => "Không tìm thấy"], 404);
        }
        return response()->json($license->examset_LicenseType);
    }
    
    public function PracticeStart(Request $request)
    {
        $examsetID = $request->input("examSetID");
        $licenseID = $request->input("licenseType");
        $examSet = ExamSet::find($examsetID);
        $license = LicenseType::find($licenseID);
        $licenseName = $license->LicenseTypeName;
        if ($licenseName) {
            $wordA = explode(" ", $licenseName);
            $lastWordA = end($wordA);
        }
        $questions = $examSet->question_Examset()->get();
        $answers = ["A" => "", "B" => "", "C" => "", "D" => ""];
        $labels = ["A", "B", "C", "D"];
        return view("userPage.quiz.practiceStart", compact("questions", "examSet", "answers", "labels", "license", "lastWordA"));
    }
    public function PracticeStartRandom($licenseID)
    {
        $license = LicenseType::find($licenseID);
        $quantity = $license->LicenseTypeQuantity;
        dd($quantity);
        $question = Question::get();
        // $questions = Question::whe
        return view("userPage.quiz.practiceRandom");

    }
    public function PracticeFinish($licenseTypeID, $ExamSetID, Request $request)
    {
        $submittedAnswers = $request->input("answers");
        $timefinish = $request->input("timeFinish");
        $isCriticalWrong = false;
        $result = [];
        $correctCount = 0;
        $sumQuestion = count($submittedAnswers);
        // $score = $sumQuestion - $correctCount;
        $examset = ExamSet::find($ExamSetID);
        $passCount = $examset->PassCount;
        // $passed = false;
        foreach ($submittedAnswers as $questionID => $answerID) {
            $question = Question::find($questionID);
            $answer = Answer::where("AnswerID", $answerID)
                ->where("QuestionID", $questionID)
                ->first();
            $findCorrect = Answer::where("QuestionID", $questionID)
                ->where("isCorrect", true)
                ->first();
            $labelCorrect = $findCorrect->AnswerLabel;
            $answerCorrect = $findCorrect->AnswerID;
            $isCorrect = $answer ? $answer->IsCorrect : false;
            if ($isCorrect) {
                $correctCount += 1;
            }
            $Iscritical = Question::where("QuestionID", $questionID)->whereHas("licenseType_Question", function ($query) use ($licenseTypeID) {
                $query->where("question_license_types.LicenseTypeID", $licenseTypeID)
                    ->where("question_license_types.IsCritical", true);
            })->exists();

            if ($question && $Iscritical == true && !$isCorrect) {
                $isCriticalWrong = true;
            }

            $result[] = [
                "QuestionID" => $questionID,
                "AnswerID" => $answerID,
                "explanation" => $question->QuestionExplain,
                "isCorrect" => $isCorrect,
                "labelCorrect" => $labelCorrect,
                "answerCorrect" => $answerCorrect,
                "time" => $timefinish,
                "sumQuestion" => $sumQuestion,
                // "Iscritical" => $Iscritical,
                // "name"=>$name

            ];
        }

        // if ($score >= $passCount && $isCorrect == true) {
        //     $passed = true;
        // } else {
        //     $passed = false;
        // }


        // if (Auth::check()) {
        //     $exam_reult = ExamResult::create([
        //         "userID" => Auth::user()->userID,
        //         "LicenseTypeID" => $licenseTypeID,
        //         "score" => $score,
        //         "passed" => $passed,
        //         "duration" => $timefinish

        //     ]);
        // } else {
        //     $exam_reult = ExamResult::create([
        //         "userID" => null,
        //         "LicenseTypeID" => $licenseTypeID,
        //         "score" => $score,
        //         "passed" => $passed,
        //         "duration" => $timefinish
        //     ]);
        // }

        return response()->json([
            'message' => 'Dữ liệu đã nhận thành công',
            'examsetID' => $ExamSetID,
            "passCount" => $passCount,
            'result' => $result,
            'iscriticalWrong' => $isCriticalWrong,
            "correctCount" => $correctCount,
        ]);
    }

     public function chapters($ID)
    {
        $chapter = QuestionCategory::find($ID);
        $chapters = QuestionCategory::all();
        $questions = $chapter->question_QuestionCategory;
        $answers = ["A" => "", "B" => "", "C" => "", "D" => ""];
        $labels = ["A", "B", "C", "D"];
        return view("userPage.quiz.chapter", compact("chapter", "questions", "answers", "labels", "chapters"));
    }

    public function collection()
    {
        $questions = Question::all();
        $answers = ["A" => "", "B" => "", "C" => "", "D" => ""];
        $labels = ["A", "B", "C", "D"];
        return view("userPage.quiz.collection", data: compact("questions", "answers", "labels"));
    }



}
