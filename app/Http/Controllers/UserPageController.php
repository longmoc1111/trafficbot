<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionCategory;
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
        return view("userPage.home.home", compact("chapter","signage"));
    }

    public function practiceExam(string $id)
    {
        $licenseID = LicenseType::find($id);
        $licenseName = $licenseID->LicenseTypeName;
        if ($licenseName) {
            $wordA = explode(" ", $licenseName);
            $lastWordA = end($wordA);
        }

        $examSets = $licenseID->examset_LicenseType;
        return view("userPage.quiz.practiceExam", compact("examSets", "licenseID", "lastWordA"));
    }
    public function PracticeStart($licenseID, $examsetID)
    {
        $examSet = ExamSet::find($examsetID);
        $license = LicenseType::find($licenseID);
        $licenseName = $license->LicenseTypeName;
        if ($licenseName) {
            $wordA = explode(" ", $licenseName);
            $lastWordA = end($wordA);
        }
        $questions = $examSet->question_Examset;
        $answers = ["A" => "", "B" => "", "C" => "", "D" => ""];
        $labels = ["A", "B", "C", "D"];
        return view("userPage.quiz.practiceStart", compact("questions", "examSet", "answers", "labels", "license", "lastWordA"));
    }
    public function PracticeFinish($ExamSetID, Request $request)
    {
        $submittedAnswers = $request->input("answers");
        $isCriticalWrong = false;
        $correctCount = 0;
        $sumQuestion = count($submittedAnswers);
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

            if ($question && $question->IsCritical == true && !$isCorrect) {
                $isCriticalWrong = true;
            }

            $result[] = [
                "QuestionID" => $questionID,
                "AnswerID" => $answerID,
                "explanation" => $question->QuestionExplain,
                "isCorrect" => $isCorrect,
                "labelCorrect" => $labelCorrect,
                "answerCorrect" => $answerCorrect,
                "sumQuestion" => $sumQuestion

            ];
        }
        return response()->json([
            'message' => 'Dữ liệu đã nhận thành công',
            'examsetID' => $ExamSetID,
            'answers' => $submittedAnswers,
            'result' => $result,
            'iscriticalWrong' => $isCriticalWrong,
            "correctCount" => $correctCount,
        ]);
    }


    public function signages($SignageTypeID)
    {
        $signagesType = SignageType::find($SignageTypeID);
        return view("userPage.quiz.signages", compact("signagesType"));
    }


    public function chapters($ID)
    {
        $chapter = QuestionCategory::find($ID);
        $chapters = QuestionCategory::all();
        $questions = $chapter->question_QuestionCategory;
        $answers = ["A" => "", "B" => "", "C" => "", "D" => ""];
        $labels = ["A", "B", "C", "D"];
        return view("userPage.quiz.chapter", compact("chapter","questions","answers","labels","chapters"));
    }



}
