<?php

namespace App\Http\Controllers;

use DB;
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
            return view("admin.questionManagement.question.listQuestion", compact("Questions", "questionCategory", "categoryKey"));
        }


    }
    public function createQuestion()
    {
        $questionCategory = QuestionCategory::all();
        $licenseTypes = LicenseType::all();
        return view("admin.questionManagement.question.createQuestion", compact("questionCategory", "licenseTypes"));
    }
    public function storeQuestion(Request $request)
    {

        $licenseTypes = $request->input('licenseTypes', []);
        $criticalTypes = $request->input('criticalTypes', []);
        //tạo 1 mãng trung gian để gán giá trị vào bảng trung gian giữa question và licensetype
        $syncData = [];
        foreach ($licenseTypes as $licenseId) {
            $syncData[$licenseId] = [
                'IsCritical' => in_array($licenseId, $criticalTypes),
            ];
        }
        // dd($criticalTypes);
        //phần validate dữ liệu
        $validateData = $request->validate(
            [
                "QuestionName" => "required",
                "QuestionExplain" => "required",
                "CategoryID" => "required",
            ],
            [
                "QuestionName.required" => "Không được để trống !",
                "QuestionExplain.required" => "Không được để trống!",
            ]
        );
        $answers = $request->input('Answers', []);
        $isCorrectIndex = $request->get('IsCorrectIndex');
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
            $file->move(storage_path("app/public/uploads/imageQuestion"), $newFileName);
            $validateData["ImageDescription"] = $newFileName;
        }
        $question = Question::create([
            "QuestionName" => $validateData["QuestionName"],
            "QuestionExplain" => $validateData["QuestionExplain"],
            "CategoryID" => $validateData["CategoryID"],
            "ImageDescription" => $validateData["ImageDescription"] ?? null,

        ]);
        if (!empty($syncData)) {
            $question->licenseType_Question()->sync($syncData);
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
        $licenseTypes = LicenseType::all();
        $question = Question::find($id);
        $questionID = $question->QuestionID;

        $licenseWithCritical = $question->licenseType_Question->map(function ($licenseType) {
            return [
                'LicenseTypeID' => $licenseType->LicenseTypeID,
                'licenseTypeName' => $licenseType->LicenseTypeName,
                'IsCritical' => (bool) $licenseType->pivot->IsCritical,
            ];
        })->toArray();
        $appliedLicenseIDs = array_column($licenseWithCritical, "LicenseTypeID");
        $criticalLicenseIDs = array_column(array_filter($licenseWithCritical, function ($item) {
            return $item["IsCritical"];
        }), "LicenseTypeID");
        $answers = $question->answer_Question()->get()->keyBy("AnswerLabel");
        foreach ($answers as $index => $answer) {
            $arrAnswers[] = [
                "AnswerID" => $answer->AnswerID,
                "AnswerName" => $answer->AnswerName,
                "AnswerLabel" => $answer->AnswerLabel,
                "IsCorrect" => $answer->IsCorrect
            ];
        }
        return view("admin.questionManagement.question.editQuestion", compact("question", "licenseTypes", "appliedLicenseIDs", "criticalLicenseIDs", "questionCategory", "arrAnswers"));
    }
    public function updateQuestion(string $id, Request $request)
    {
         
        $licenseTypes = $request->input("licenseTypes", []);
        $critical = $request->input("criticalTypes", []);
        $answerIDs = $request->input("AnswerIDs", []);
        $answerRequest = $request->get(key: "Answers");
        $isCorrectIndex = $request->get("IsCorrectIndex") ?? null;
        $dataSync = [];

        $validateData = $request->validate(
            [
                "QuestionName" => "required",
                "QuestionExplain" => "required",
                "CategoryID" => "required",
            ],
            [
                "QuestionName.required" => "Không được để trống !",
                "QuestionExplain.required" => "Không được để trống!",
            ]
        );
        $AnswerFilter = array_filter($answerRequest, function ($value) {
            return !is_null($value) && trim($value) !== '';
        });
        if (empty($AnswerFilter)) {
            return back()->with("answer_null", "Hãy tạo ít nhất 1 câu trả lời!");
        }
        if (is_null($isCorrectIndex)) {
            return back()->with("iscorrect_null", "bạn chưa chọn đáp án đúng cho câu hỏi!");
        }
        foreach ($licenseTypes as $licenseTypeID) {
            $dataSync[$licenseTypeID] = ["Iscritical" => in_array($licenseTypeID, $critical)];
        }


        $question = Question::find($id);
        if (!$question) {
            return back()->with("err_id", "Không tìm thấy câu hỏi cần cập nhật !");
        }
        if ($request->hasFile("ImageDescription")) {
            if ($request->hasfile("OldImageDescription")) {
                $oldfile = storage_path("app/public/uplaods/imageQuestion" . $request->get("oldImageDescription"));
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }
            $file = $request->file("ImageDescription");
            $fileNameWithoutExt = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileNameExt = $file->getClientOriginalExtension();
            $newfileName = $fileNameWithoutExt . "_" . time() . "." . $fileNameExt;
            $validateData["ImageDescription"] = $newfileName;
            $file->move(storage_path("app/public/uploads/imageQuestion"), $newfileName);
        }
        $question->update([
            "QuestionName" => $validateData["QuestionName"],
            "QuestionExplain" => $validateData["QuestionExplain"],
            "CategoryID" => $validateData["CategoryID"],
            "ImageDescription" => $validateData["ImageDescription"] ?? null,
        ]);
        if ($question) {
            $question->licenseType_Question()->sync($dataSync);
        }

        $labels = ["A", "B", "C", "D"];
        $labelIndex = 0;
        foreach ($answerRequest as $index => $name) {
            $answerID = $answerIDs[$index] ?? null;
            if (is_null($name) || trim($name) === "") {
                if ($answerID) {
                    Answer::where("AnswerID", $answerID)->delete();
                }
                continue;
            }
            $label = $labels[$labelIndex] ?? null;
            $labelIndex++;
            if ($answerID) {
                Answer::where("AnswerID", $answerID)->update([
                    "AnswerName" => $name,
                    "AnswerLabel" => $label,
                    "IsCorrect" => ($isCorrectIndex !== null && intval($isCorrectIndex) === $index),
                    "QuestionID" => $question->QuestionID
                ]);
            } else {
                Answer::create([
                    "AnswerName" => $name,
                    "AnswerLabel" => $label,
                    "IsCorrect" => ($isCorrectIndex !== null && intval($isCorrectIndex) === $index),
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
        $licenseTypeID = $examSet->licenseType_Examset->pluck("LicenseTypeID")->first();

        $licenseType = LicenseType::all();
        foreach ($examSet->licenseType_Examset as $license) {
            $licenseTypeExs[$license->LicenseTypeID] = $license->LicenseTypeName;
        }
        foreach ($licenseType as $license) {
            $allLicenseType[$license->LicenseTypeID] = $license->LicenseTypeName;
        }
        $categoryQuantity = DB::table("license_type_question_category")
            ->where("LicenseTypeID", $licenseTypeID)
            ->pluck("Quantity", "CategoryID")
            ->toArray();

        return view("admin.questionManagement.question.createQuestion_ExamSet", compact("examSet", "questionCategory", "licenseTypeExs", "allLicenseType", 'categoryQuantity'));
    }
    public function storeQuestion_ExamSet(string $id, Request $request)
    {
        $licenseTypeID = $request->get("licenseTypeID");
        $licenseType = LicenseType::find($licenseTypeID);
        $quantity = $licenseType->LicenseTypeQuantity;
        $countCurrentQuestion = 0;
        $questionCreated = 0;
        $examset = ExamSet::find($id);
        $isCritical = false;
        $currentQuestions = $examset->question_Examset()->get();
        if ($currentQuestions) {
            $countCurrentQuestion = count($currentQuestions);
            if ($countCurrentQuestion > 0) {
                return redirect()->route("admintrafficbot.examset.show", $examset->ExamSetID)
                    ->with("quantity_max", "Bộ đề đã có câu hỏi không thể khởi tạo lại!");
            }
        }
        $countQuestion = 0;
        $amounts = $request->input('amounts', []);
        foreach ($amounts as $index => $item) {
            $countQuestion += $item;
        }
        if ($countQuestion != $quantity) {
            return back()->withErrors(["quantity_error" => "Bộ đề yêu cầu số lượng $quantity câu hỏi!"]);
        }
        // foreach($amounts as $categoryID => $count){
        //     $iscritical = Question::where("CategoryID", $categoryID)
        //         ->whereDoesntHave("examset_Question", function($q1) use($licenseTypeID){
        //         $q1->whereHas("licenseType_Examset", function($q2) use($licenseTypeID){
        //             $q2->where("exam_set_license_type.LicenseTypeID",$licenseTypeID );
        //         });
        //     })->get();
        //     $questionIdToAttach[] = $iscritical;
        // }
        // dd($questionIdToAttach);
        $questionIdToAttach = [];
        foreach ($amounts as $categoryID => $count) {
            if ($isCritical == false) {
                $isCriticalQuestion = Question::where("CategoryID", $categoryID)
                    ->whereHas("licenseType_Question", function ($query) use ($licenseTypeID) {
                        $query->where('question_license_types.LicenseTypeID', $licenseTypeID)
                            ->where("question_license_types.Iscritical", 1);
                    })
                    ->whereDoesntHave("examSet_Question", function($q1) use($licenseTypeID){
                        $q1->whereHas("licenseType_Examset", function($q2) use($licenseTypeID){
                            $q2->where("exam_set_license_type.LicenseTypeID", $licenseTypeID);
                        });
                    })
                    ->inRandomOrder()
                    ->pluck("QuestionID")
                    ->first();
                if ($isCriticalQuestion) {
                    $isCritical = true;
                    $count--;
                } else {
                    return back()->withErrors(["iscritical_null" => "Không tìm thấy câu điểm liệt!"]);
                }
            }
            if ($count > 0) {
                $questions = Question::where("CategoryID", $categoryID)
                    ->whereHas("licenseType_Question", function ($query) use ($licenseTypeID) {
                        $query->where("question_license_types.LicenseTypeID", $licenseTypeID)
                            ->where("question_license_types.Iscritical", 0);
                    })
                    ->whereDoesntHave("examSet_Question", function($q1) use($licenseTypeID){
                        $q1->whereHas("licenseType_Examset", function($q2) use($licenseTypeID){
                            $q2->where("exam_set_license_type.LicenseTypeID", $licenseTypeID);
                        });
                    })
                    ->inRandomOrder()
                    ->limit($count)
                    ->pluck("QuestionID")
                    ->toArray();
                $questionIdToAttach = array_merge($questionIdToAttach, $questions);

            }
        }
        if(isset($isCriticalQuestion)){
            $maxInsertIndex = floor(count($questionIdToAttach) / 2);
            $insertIndex = rand(0, $maxInsertIndex);
            array_splice($questionIdToAttach, $insertIndex, 0 , $isCriticalQuestion);
        }
        // dd($questionIdToAttach);
      
        foreach ($questionIdToAttach as $index => $item) {
            $questionCreated += $item;
        }
        if ($questionCreated <= $quantity) {
            return back()->withErrors(["question_created" => "Không đủ số lượng câu hỏi để tạo bộ đề mới!"]);
        }
        if ($examset) {
            foreach ($questionIdToAttach as $questionID) {
                $examset->question_Examset()->attach($questionID);
            }
            return redirect()->route("admintrafficbot.examset.show", $examset->ExamSetID)->with("create_success", "Tạo danh sách câu hỏi mới thành công!");
        } else {
            return redirect()->route("admintrafficbot.examset.show", $examset->ExamSetID)->with("create_fails", "Tạo danh sách câu hỏi Không thành công!");
        }
    }
}

