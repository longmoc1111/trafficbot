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

        $syncData = [];
        foreach ($licenseTypes as $licenseId) {
            $syncData[$licenseId] = [
                'IsCritical' => in_array($licenseId, $criticalTypes),
            ];
        }

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
        $answers = $request->get('Answers');
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

        $licenseType = (array) $request->get("LicenseTypeID");
        if (isset($licenseType)) {
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
        $answerRequest = $request->get("Answers");
        $isCorrectIndex = $request->get("IsCorrectIndex");
        $dataSync = [];
        foreach ($licenseTypes as $licenseTypeID) {
            $dataSync[$licenseTypeID] = ["Iscritical" => in_array($licenseTypeID, $critical)];
        }
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
        ;
        $countQuestion = 0;
        $amounts = $request->input('amounts', []);


        foreach ($amounts as $index => $item) {
            $countQuestion += $item;
        }
            if ($countQuestion != $quantity - 1) {
                return back()->withErrors(["quantity_error" => "Bộ đề yêu cầu số lượng $quantity câu hỏi!"]);
            }else if($countQuestion == $quantity){
                return back()->withErrors(["quantity_error" => "Số lượng câu hỏi đã đủ $quantity câu!"]);
            }


        $questionIdToAttach = [];
        foreach ($amounts as $categoryID => $count) {
            $questions = Question::where("CategoryID", $categoryID)

                ->whereHas("licenseType_Question", function ($query) use ($licenseTypeID) {
                    $query->where('question_license_types.LicenseTypeID', $licenseTypeID)
                        ->where("question_license_types.Iscritical", "!=", 1);
                })
                ->whereDoesntHave("examSet_Question")
                ->inRandomOrder()
                ->limit($count)
                ->pluck("QuestionID")
                ->toArray();
            $questionIdToAttach = array_merge($questionIdToAttach, $questions);
        }
        $questionCreated = 0;
        foreach ($questionIdToAttach as $index => $item) {
            $questionCreated += $item;
        }




        if($questionIdToAttach == null){
            return back()->withErrors(["arr_question_null"=> "Số lượng câu hỏi "]);
        }

        $IsCritical = Question::whereHas("licenseType_Question", function ($query) use ($licenseTypeID) {
            $query->where("question_license_types.LicenseTypeID", $licenseTypeID)
                ->where("question_license_types.IsCritical", $licenseTypeID);
        })
            ->whereDoesntHave("examSet_Question")
            ->inRandomOrder()
            ->first();

        if ($IsCritical == null) {
            return back()->withErrors(["iscritical_null" => "Không tìm thấy câu điểm liệt!"]);
        }
        if ($questionCreated <= $quantity - 1) {
            return back()->withErrors(["question_created" => "Không đủ số lượng câu hỏi để tạo bộ đề mới!"]);
        }
        $randomIndex = rand(0, count($questionIdToAttach) / 2);
        array_splice($questionIdToAttach, $randomIndex, 0, [$IsCritical->QuestionID]);
        // dd($questionIdToAttach);
        $examset = ExamSet::find($id);
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

