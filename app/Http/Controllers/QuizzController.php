<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\ExamResult;
use App\Models\Question;
use App\Models\QuestionCategory;
use Auth;
use Illuminate\Http\Request;
use App\Models\LicenseType;
use Illuminate\Support\Collection;

use App\Models\ExamSet;


class QuizzController extends Controller
{
    public function practiceExam(string $id)
    {

        $license = LicenseType::find($id);
        if ($license) {
            $licenseName = $license->LicenseTypeName;
            if ($licenseName) {
                $wordA = explode(" ", $licenseName);
                $lastWordA = end($wordA);
            }

            $examSets = $license->examset_LicenseType;
            return view("userPage.quiz.practiceExam", compact("examSets", "license", "lastWordA"));
        } else {
            return abort(404);
        }

    }
    public function practiceTest()
    {
        $licenses = LicenseType::all();
        return view("userPage.quiz.practiceTest", compact("licenses"));
    }

    public function getInfo($licenseID)
    {
        $license = LicenseType::with("questionCategory_LicenseType")->find($licenseID);
        $dataInfo = [];
        if (!$license) {
            return response()->json(["error" => "Không tìm thấy dữ liệu!"], 404);
        }
        $dataLicense = [
            "duration" => $license->LicenseTypeDuration,
            "name" => $license->LicenseTypeName,
            "passcount" => $license->LicenseTypePassCount,
            "quantity" => $license->LicenseTypeQuantity

        ];
        $dataCategory = $license->questionCategory_LicenseType->map(function ($category) {
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

    public function getExam($licensenID)
    {
        $license = LicenseType::with("examset_LicenseType")->find($licensenID);
        if (!$license) {
            return response()->json(["error" => "Không tìm thấy"], 404);
        }
        return response()->json($license->examset_LicenseType);
    }

    public function PracticeStart(Request $request)
    {
        $examsetID = $request->input("examSetID");
        $licenseID = $request->input("licenseType");
        $QuestionsRandom = [];
        $amount = [];
        if ($examsetID == "random") {
            
            $critical = false;
            $license = LicenseType::find($licenseID);
             $licenseTypes = LicenseType::all();
            $licenseName = $license->LicenseTypeName;
            if ($licenseName) {
                $wordA = explode(" ", $licenseName);
                $lastWordA = end($wordA);
            }
            $answers = ["A" => "", "B" => "", "C" => "", "D" => ""];
            $labels = ["A", "B", "C", "D"];
            foreach ($license->questionCategory_LicenseType as $category) {
                $amount[$category->CategoryID] = $category->pivot->Quantity;
            }
            

            $questions = collect();

            foreach ($amount as $categoryID => $count) {
                $categoryQuestions = collect();

                if ($critical === false) {
                    $isCriticalQuestion = Question::where("CategoryID", $categoryID)
                        ->whereHas("licenseType_Question", function ($query) use ($license) {
                            $query->where("question_license_types.LicenseTypeID", $license->LicenseTypeID)
                                ->where("question_license_types.Iscritical", 1);
                        })
                        ->inRandomOrder()
                        ->first();
                    
                    if ($isCriticalQuestion) {
                        $critical = true;
                        $count--;
                    }
                }

                if ($count > 0) {
                    $normalQuestions = Question::where("CategoryID", $categoryID)
                        ->whereHas("licenseType_Question", function ($query) use ($license) {
                            $query->where("question_license_types.LicenseTypeID", $license->LicenseTypeID)
                                ->where("question_license_types.Iscritical", 0);
                        })
                        ->inRandomOrder()
                        ->limit($count)
                        ->get();

                    $categoryQuestions = $categoryQuestions->merge($normalQuestions);
                }
                $questions = $questions->merge($categoryQuestions); // Gộp vào bộ đề chính
            }
            if($isCriticalQuestion){
                $total = $questions->count();
                $index = rand(1, floor($total/2));
                $before = $questions->slice(0, $index);
                $after = $questions->slice($index);
                $questions = $before->push($isCriticalQuestion)->merge($after);
            }
            return view("userPage.quiz.practiceStart", compact("questions", "examsetID", "answers", "labels", "license", "lastWordA", "licenseTypes"));
        }else{
            $examSet = ExamSet::find($examsetID);
            $examsetID = $examSet->ExamSetID;
            $license = LicenseType::find($licenseID);
            $licenseTypes = LicenseType::all();
            $licenseName = $license->LicenseTypeName;
            if ($licenseName) {
                $wordA = explode(" ", $licenseName);
                $lastWordA = end($wordA);
            }
            $questions = $examSet->question_Examset()->get();
            $answers = ["A" => "", "B" => "", "C" => "", "D" => ""];
            $labels = ["A", "B", "C", "D"];
            return view("userPage.quiz.practiceStart", compact("questions", "examsetID", "answers", "labels", "license", "lastWordA", "licenseTypes"));
        }

       
    }
    public function PracticeFinish($licenseTypeID, Request $request)
    {
        $submittedAnswers = $request->input("answers");
        $timefinish = $request->input("timeFinish");
        $isCriticalWrong = false;
        $result = [];
        $correctCount = 0;
        $sumQuestion = count($submittedAnswers);
        $licenseType = LicenseType::find($licenseTypeID);
        $passCount = $licenseType->LicenseTypePassCount;
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
        if ($correctCount >= $passCount && !$isCriticalWrong) {
            $passed = true;
        } else {
            $passed = false;
        }


        if(Auth::check()) {
            $exam_reult = ExamResult::create([
                "userID" => Auth::user()->userID,
                "LicenseTypeID" => $licenseTypeID,
                "score" => $correctCount,
                "passed" => $passed,
                "duration" => $timefinish

            ]);
        } else {
            $exam_reult = ExamResult::create([
                "userID" => null,
                "LicenseTypeID" => $licenseTypeID,
                "score" => $correctCount,
                "passed" => $passed,
                "duration" => $timefinish
            ]);
        }

        return response()->json([
            'message' => 'Dữ liệu đã nhận thành công',
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

    public function collectionA($ID)
    {
        $chapter = QuestionCategory::find($ID);
        $licenseType = LicenseType::where("LicenseTypeName", "A1")->first();
        $chapters = QuestionCategory::whereHas("question_QuestionCategory", function ($query) use ($licenseType) {
            $query->whereHas("licenseType_Question", function ($subQuery) use ($licenseType) {
                $subQuery->where("question_license_types.LicenseTypeID", $licenseType->LicenseTypeID);
            });
        })->get();
        // dd($chapter);
        $questions = Question::whereHas("licenseType_Question", function ($query) use ($licenseType) {
            $query->where("question_license_types.LicenseTypeID", $licenseType->LicenseTypeID);
        })->where("CategoryID", $chapter->CategoryID)->get();
        $answers = ["A" => "", "B" => "", "C" => "", "D" => ""];
        $labels = ["A", "B", "C", "D"];
        return view("userPage.quiz.collection", data: compact("chapter", "licenseType", "chapters", "questions", "answers", "labels"));
    }
    public function collectionBOne($ID)
    {
        $chapter = QuestionCategory::find($ID);
        $licenseType = LicenseType::where("LicenseTypeName", "B1")->first();
        $chapters = QuestionCategory::whereHas("question_QuestionCategory", function ($query) use ($licenseType) {
            $query->whereHas("licenseType_Question", function ($subQuery) use ($licenseType) {
                $subQuery->where("question_license_types.LicenseTypeID", $licenseType->LicenseTypeID);
            });
        })->get();
        $questions = Question::whereHas("licenseType_Question", function ($query) use ($licenseType) {
            $query->where("question_license_types.LicenseTypeID", $licenseType->LicenseTypeID);
        })->where("CategoryID", $chapter->CategoryID)->get();
        $answers = ["A" => "", "B" => "", "C" => "", "D" => ""];
        $labels = ["A", "B", "C", "D"];
        return view("userPage.quiz.collection", data: compact("chapter", "licenseType", "chapters", "questions", "answers", "labels"));
    }



}
