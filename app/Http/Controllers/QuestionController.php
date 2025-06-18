<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\LicenseType;
use App\Models\Answer;
use App\Models\ExamSet;



class QuestionController extends Controller
{
    public function listQuestion()
    {
        $categoryKey = request("category");
        $questionCategory = QuestionCategory::all();
        if ($categoryKey) {
            $Questions = Question::where("CategoryID", $categoryKey)->paginate(10);
            return view("admin.questionManagement.question.listQuestion", compact("Questions", "questionCategory", "categoryKey"));
        } else {
            $Questions = Question::orderBy("QuestionID", "ASC")->paginate(10);
            return view("admin.questionManagement.question.listQuestion", compact("Questions", "questionCategory"));
        }

    }

    public function serachQuestion()
    {
        $key = request("search");
        $categoryKey = request("category");
        $questionCategory = QuestionCategory::all();
        if ($categoryKey) {
            $Questions = Question::where("CategoryID", $categoryKey)->paginate(10);
            return view("admin.questionManagement.question.listQuestion", compact("Questions", "questionCategory", "categoryKey"));
        } else {
            $Questions = Question::where("QuestionName", "like", "%" . $key . "%")
                ->paginate(10)->appends(request()->query());
            return view("admin.questionManagement.question.listQuestion", compact("Questions", "questionCategory","categoryKey"));
        }


    }
    public function createQuestion()
    {
        $questionCategory = QuestionCategory::all();
        $licenseTypes = LicenseType::all();
        return view("admin.questionmanagement.question.createQuestion", compact("questionCategory", "licenseTypes"));
    }
    public function storeQuestion(Request $request)
    {
        $validateData = $request->validate(
            [
                "QuestionName" => "required",
                "QuestionExplain" => "required",
                "IsCritical" => "required",
                "CategoryID" => "required",
            ],
            [
                "QuestionName.required" => "Không được để trống !",
                "QuestionExplain.required" => "Không được để trống!",
            ]
        );
        $answers = $request->get('Answers'); // Mảng các đáp án
        $isCorrectIndex = $request->get('IsCorrectIndex'); // Chỉ 1 index hoặc null nếu không có
        if (is_null($isCorrectIndex)) {
            return back()->with("iscorrect_null", "bạn chưa chọn đáp án đúng cho câu hỏi!");
        }
        $validAnswers = array_filter($answers, function ($value) {
            return !is_null($value) && trim($value) !== '';
        });
        if (empty($validAnswers)) {
            return back()->with("answer_null", "Hãy tạo ít nhất 1 câu trả lời!");
        }
        foreach ($answers as $index => $answerName) {
            $answerFromRequest[] = [
                'AnswerName' => $answerName,
                'IsCorrect' => ($isCorrectIndex !== null && intval($isCorrectIndex) === $index),
            ];
        }
        if ($request->hasFile("ImageDescription")) {
            $file = $request->file("ImageDescription");
            $fileNameWithoutExt = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileNameExt = $file->getClientOriginalExtension();
            $newFileName = $fileNameWithoutExt . "_" . time() . "." . $fileNameExt;
            $file->move(public_path("assets/adminPage/imageQuestion"), $newFileName);
            $validateData["ImageDescription"] = $newFileName;
        }
        $question = Question::create([
            "QuestionName" => $validateData["QuestionName"],
            "QuestionExplain" => $validateData["QuestionExplain"],
            "IsCritical" => $validateData["IsCritical"],
            "CategoryID" => $validateData["CategoryID"],
            "ImageDescription" => $validateData["ImageDescription"] ?? null,

        ]);

        $licenseType = (array) $request->get("LicenseTypeID");
        if (isset($licenseType)) {
            $question->licenseType_Question()->attach($licenseType);
        }

        $answerFilter = array_filter($answerFromRequest, function ($value) {
            return !is_null($value) && $value["AnswerName"] != null;
        });
        $labels = ["A", "B", "C", "D"];
        $labelForQS = array_slice($labels, 0, count($answerFilter));
        foreach ($answerFilter as $index => $data) {
            Answer::create([
                "AnswerName" => $data["AnswerName"],
                "IsCorrect" => $data["IsCorrect"],
                "AnswerLabel" => $labelForQS[$index],
                "QuestionID" => $question->QuestionID,
            ]);
        }
        return redirect()->route("admintrafficbot.question")->with("add_question", "thêm câu hỏi mới thành công !");


    }
    public function deleteQuestion(string $id)
    {
        $question = Question::find($id);
        if (isset($question)) {
            $question->licenseType_Question()->detach();
            $question->examSet_Question()->detach();
            foreach ($question->answer_Question as $answer) {
                $answer->delete();
            }
            $question->delete();
            return redirect()->route("admintrafficbot.question")->with("delete_question", "xoá thành công !");

        } else {
            return redirect()->route("admintrafficbot.question")->with("err_delete_question", "Không xác định được câu hỏi cần xóa !");
        }
    }

    public function editQuestion(string $id)
    {
        $questionCategory = QuestionCategory::all();
        $licenseType = LicenseType::all();
        $question = Question::find($id);


        foreach ($licenseType as $license) {
            $allLicens[$license->LicenseTypeID] = $license->LicenseTypeName;
        }
        foreach ($question->licenseType_Question as $license) {
            $allLicenseForQS[$license->LicenseTypeID] = $license->LicenseTypeName;
        }

        $answers = $question->answer_Question()->get()->keyBy("AnswerLabel");
        foreach ($answers as $index => $answer) {
            $arrAnswers[] = [
                "AnswerName" => $answer->AnswerName,
                "AnswerLabel" => $answer->AnswerLabel,
                "IsCorrect" => $answer->IsCorrect
            ];
        }
        return view("admin.questionManagement.question.editQuestion", compact("question", "allLicens", "allLicenseForQS", "questionCategory", "arrAnswers"));
    }
    public function updateQuestion(string $id, Request $request)
    {
        $validateData = $request->validate(
            [
                "QuestionName" => "required",
                "QuestionExplain" => "required",
                "IsCritical" => "required",
                "CategoryID" => "required",
            ],
            [
                "QuestionName.required" => "Không được để trống !",
                "QuestionExplain.required" => "Không được để trống!",
            ]
        );
        $answerRequest = $request->get("Answers");
        $isCorrectIndex = $request->get("IsCorrectIndex");

        $AnswerFilter = array_filter($answerRequest, function ($value) {
            return !is_null($value) && trim($value) !== '';
        });

        if (empty($AnswerFilter)) {
            return back()->with("answer_null", "Hãy tạo ít nhất 1 câu trả lời!");
        }
        if (is_null($isCorrectIndex)) {
            return back()->with("iscorrect_null", "bạn chưa chọn đáp án đúng cho câu hỏi!");
        }

        foreach ($AnswerFilter as $index => $answer) {
            $Answers[] = [
                "Answers" => $answer,
                "IsCorrect" => ($isCorrectIndex != null && intval($isCorrectIndex) === $index)
            ];
        }
        $labels = ["A", "B", "C", "D"];
        $labelForQS = array_slice($labels, 0, count($Answers));
        $question = Question::find($id);
        if (!$question) {
            return back()->with("err_id", "Không tìm thấy câu hỏi cần cập nhật !");
        }
        if ($request->hasFile("ImageDescription")) {
            if ($request->hasfile("OldImageDescription")) {
                $oldfile = public_path("assets/adminPage/iamgeQuestion" . $request->get("oldImageDescription"));
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }
            $file = $request->file("ImageDescription");
            $fileNameWithoutExt = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileNameExt = $file->getClientOriginalExtension();
            $newfileName = $fileNameWithoutExt . "_" . time() . "." . $fileNameExt;
            $validateData["ImageDescription"] = $newfileName;
            $file->move(public_path("assets/adminPage/imageQuestion"), $newfileName);
        }
        $question->update([
            "QuestionName" => $validateData["QuestionName"],
            "QuestionExplain" => $validateData["QuestionExplain"],
            "IsCritical" => $validateData["IsCritical"],
            "CategoryID" => $validateData["CategoryID"],
            "ImageDescription" => $validateData["ImageDescription"] ?? null,
        ]);
        $licenseTypeID = $request->get("LicenseTypeID");
        if (isset($licenseTypeID)) {
            $question->licenseType_Question()->sync($licenseTypeID);
        }
        $answer = $question->answer_Question()->get()->keyBy("AnswerLabel");
        foreach ($Answers as $index => $data) {
            if (isset($answer[$labelForQS[$index]])) {
                $answer[$labelForQS[$index]]->update([
                    "AnswerName" => $data["Answers"],
                    "IsCorrect" => $data["IsCorrect"],
                    "QuestionID" => $question->QuestionID
                ]);
            } else {
                Answer::create([
                    "AnswerLabel" => $labelForQS[$index],
                    "AnswerName" => $data["Answers"],
                    "IsCorrect" => $data["IsCorrect"],
                    "QuestionID" => $question->QuestionID
                ]);
            }

        }
        return redirect()->route("admintrafficbot.question")->with("update_question", "cập nhật câu hỏi thành công !");


    }
    public function detailQuestion(string $id)
    {
        $question = Question::find($id);
        $answer = $question->answer_Question()->get()->keyBy("AnswerLabel");
        $answerA = $answer["A"] ?? null;
        $answerB = $answer["B"] ?? null;
        $answerC = $answer["C"] ?? null;
        $answerD = $answer["D"] ?? null;
        $correctAnswer = $answer->firstWhere("IsCorrect", true)->AnswerLabel ?? null;
        return view("admin.questionManagement.question.detailQuestion", compact("question", "answerA", "answerB", "answerC", "answerD", "correctAnswer", "answer"));
    }

    public function createQuestion_ExamSet(string $id)
    {
        $examSet = ExamSet::find($id);
        $questionCategory = QuestionCategory::all();
        $licenseType = LicenseType::all();
        foreach ($examSet->licenseType_Examset as $license) {
            $licenseTypeExs[$license->LicenseTypeID] = $license->LicenseTypeName;
        }
        foreach ($licenseType as $license) {
            $allLicenseType[$license->LicenseTypeID] = $license->LicenseTypeName;
        }
        return view("admin.questionManagement.question.createQuestion_ExamSet", compact("examSet", "questionCategory", "licenseTypeExs", "allLicenseType"));
    }
    public function storeQuestion_ExamSet(string $id, Request $request)
    {
    
    // dd($request->all());
    $amounts = $request->input('amounts', []);
    $questionIdToAttach = [];
   foreach($amounts as $categoryID => $count){
    $questions = Question::where("CategoryID", $categoryID)
                ->inRandomOrder()
                ->limit($count)
                ->pluck("QuestionID ")
                ->toArray();
    $questionIdToAttach = array_merge($questionIdToAttach, $questions);
   }
   $examset = ExamSet::find($id);
   if($examset){
   $examset->question_Examset()->syncWithoutDetaching($questionIdToAttach);
      return redirect()->route("admintrafficbot.examset.show", $examset->ExamSetID)->with("create_success", "Tạo danh sách câu hỏi mới thành công!");
   }else{
      return redirect()->route("admintrafficbot.examset.show", $examset->ExamSetID)->with("create_fails", "Tạo danh sách câu hỏi Không thành công!");

   }


    //     $validateData = $request->validate(
    //         [
    //             "QuestionName" => "required",
    //             "QuestionExplain" => "required",
    //             "IsCritical" => "required",
    //             "CategoryID" => "required",
    //         ],
    //         [
    //             "QuestionName.required" => "Không được để trống !",
    //             "QuestionExplain.required" => "Không được để trống!",
    //         ]
    //     );
    //     $answers = $request->get('Answers'); // Mảng các đáp án
    //     $isCorrectIndex = $request->get('IsCorrectIndex'); // Chỉ 1 index hoặc null nếu không có
    //     if ($isCorrectIndex == null) {
    //         return back()->with("iscorrect_null", "bạn chưa chọn đáp án đúng cho câu hỏi!");
    //     }
    //     $validAnswers = array_filter($answers, function ($value) {
    //         return !is_null($value) && trim($value) !== '';
    //     });
    //     if (empty($validAnswers)) {
    //         return back()->with("answer_null", "Hãy tạo ít nhất 1 câu trả lời!");
    //     }
    //     foreach ($answers as $index => $answerName) {
    //         $answerFromRequest[] = [
    //             'AnswerName' => $answerName,
    //             'IsCorrect' => ($isCorrectIndex !== null && intval($isCorrectIndex) === $index),
    //         ];
    //     }
    //     if ($request->hasFile("ImageDescription")) {
    //         $file = $request->file("ImageDescription");
    //         $fileNameWithoutExt = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    //         $fileNameExt = $file->getClientOriginalExtension();
    //         $newFileName = $fileNameWithoutExt . "_" . time() . "." . $fileNameExt;
    //         $file->move(public_path("assets/adminPage/imageQuestion"), $newFileName);
    //         $validateData["ImageDescription"] = $newFileName;
    //     }
    //     $question = Question::create([
    //         "QuestionName" => $validateData["QuestionName"],
    //         "QuestionExplain" => $validateData["QuestionExplain"],
    //         "IsCritical" => $validateData["IsCritical"],
    //         "CategoryID" => $validateData["CategoryID"],
    //         "ImageDescription" => $validateData["ImageDescription"] ?? null,

    //     ]);


    //     $examSet = ExamSet::find($id);
    //     $licenseType = (array) $request->get("LicenseTypeID");
    //     if (isset($examSet)) {
    //         $question->examSet_Question()->attach($examSet->ExamSetID);
    //     }
    //     if (isset($licenseType)) {
    //         $question->licenseType_Question()->attach($licenseType);
    //     }

    //     $answerFilter = array_filter($answerFromRequest, function ($value) {
    //         return !is_null($value) && $value["AnswerName"] != null;
    //     });
    //     $labels = ["A", "B", "C", "D"];
    //     $labelForQS = array_slice($labels, 0, count($answerFilter));
    //     foreach ($answerFilter as $index => $data) {
    //         Answer::create([
    //             "AnswerName" => $data["AnswerName"],
    //             "IsCorrect" => $data["IsCorrect"],
    //             "AnswerLabel" => $labelForQS[$index],
    //             "QuestionID" => $question->QuestionID,
    //         ]);
    //     }
    //     return redirect()->route("admintrafficbot.examset.show", $examSet->ExamSetID)->with("add_question_success", "thêm mới câu hỏi cho $examSet->ExamSetName thành công !");
    }
}
