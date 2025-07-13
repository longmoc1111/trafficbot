<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LicenseType;
use App\Models\ExamSet;
use function Laravel\Prompts\select;


class ExamSetController extends Controller
{
    public function listExamSet(Request $request)
    {
        $selectLicenseTypes = LicenseType::get();
        $chooseLicense = $request->get("choose_License");
        if (!empty($chooseLicense)) {
            $LicenseType = LicenseType::where("LicenseTypeID", $chooseLicense)->first();
            $examSet = ExamSet::whereHas("licenseType_Examset", function ($query) use ($LicenseType) {
                $query->where("exam_set_license_type.LicenseTypeID", $LicenseType->LicenseTypeID);
            })->with("licenseType_ExamSet")->paginate(10);
        } else {
            $LicenseType = LicenseType::with("examset_LicenseType")->first();
            $examSet = ExamSet::whereHas("licenseType_Examset", function ($query) use ($LicenseType) {
                $query->where("exam_set_license_type.LicenseTypeID", $LicenseType->LicenseTypeID);
            })->with("licenseType_ExamSet")->paginate(10);
        }
        return view("admin.examSetManagement.listExamset", compact("selectLicenseTypes", "LicenseType", "examSet"));

    }

    public function createExamSet($ID)
    {
        $listLicense = LicenseType::where("LicenseTypeID", $ID)->first();
        if ($listLicense) {
            $currenlicenseID = $listLicense->LicenseTypeID;
        }
        $listExamset = ExamSet::WhereDoesntHave("licenseType_ExamSet", function ($query) use ($currenlicenseID) {
            $query->where("license_types.LicenseTypeID", $currenlicenseID);
        })->get();
        $License = LicenseType::get();
        return view("admin.examSetManagement.createExamSet", compact("currenlicenseID", "listLicense", "License", "listExamset"));
    }
    public function storeExamSet(Request $request)
    {
        $examSetName = $request->get("ExamSetName");
        $licenseTypeID = $request->get("LicenseTypeID");
        $examSetID = $request->get("ExamSetID");

        if (empty($examSetName) && empty($examSetID)) {
            return back()->with("errmissing", "Vui lòng nhập tên bộ đề mới hoặc chọn bộ đề có sẵn !");
        }
        if (!empty($examSetName) && !empty($examSetID)) {
            return back()->with("erronly", "chỉ tạo bộ đề mới hoặc chọn bộ đề có sẵn có sẵn, không nhập cả 2 !");
        } else if (!empty($examSetName) && empty($examSetID)) {
            $examsets = ExamSet::where("ExamSetName", $examSetName)->get();
            foreach ($examsets as $examset) {
                $exists = DB::table("exam_set_license_type")
                    ->where("ExamSetID", $examset->ExamSetID)
                    ->where("LicenseTypeID", $licenseTypeID)
                    ->exists();
                if ($exists) {
                    return back()->with("error_examset_exists", "bộ đề này đã tồn tại đối với giấy phép !");
                }
            }
            $newExamSet = ExamSet::create(["ExamSetName" => $examSetName]);
            $newExamSet->licenseType_ExamSet()->attach($licenseTypeID);
            return redirect()->route("admintrafficbot.examset")->with("add_examset", "Thêm mới bộ đề thành công !");
        } else if (empty($examSetName) && !empty($examSetID)) {
            $newExamSet = ExamSet::find($examSetID);
            if ($newExamSet) {
                $newExamSet->licenseType_ExamSet()->attach($licenseTypeID);
                return redirect()->route("admintrafficbot.examset", ["choose_License" => $licenseTypeID])->with("Thêm mới bộ đề thành công !");
            } else {
                return back()->with("err_examset_not_found", "Bộ đề bạn chọn không tồn tại !");
            }
        }

    }
    public function deleteExamSet(string $id)
    {
        $examset = ExamSet::find($id);
        $examsetname = $examset->ExamSetName;
        if (isset($examset)) {
            $examset->licenseType_Examset()->detach();
            $examset->question_ExamSet()->detach();
        }
        $examset->delete();
        return redirect()->route("admintrafficbot.examset")->with("delete_exam", "Xóa thành công $examsetname !");
    }
    public function editExamSet(string $id)
    {
        $editExamSet = ExamSet::find($id);
        $listLicenseType = LicenseType::get();
        if (isset($editExamSet)) {
            foreach ($editExamSet->licenseType_ExamSet as $license) {
                $ExsLicense[$license->LicenseTypeID] = $license->LicenseTypeName;
            }
        }
        if (isset($listLicenseType)) {
            foreach ($listLicenseType as $license) {
                $AllLicense[$license->LicenseTypeID] = $license->LicenseTypeName;
            }
        }
        return view("admin.examSetManagement.editExamSet", compact("editExamSet", "listLicenseType", "ExsLicense", "AllLicense"));
    }
    public function updateExamSet(Request $request, string $id)
    {
        $examSetName = $request->get("ExamSetName");
        $licenseIDs = $request->get("LicenseTypeID");
        $validate = $request->validate(
            [
                "ExamSetName" => "required",
            ],
            [
                "required" => "Không được để trống !",
            ]
        );
        $existing = DB::table("exam_sets")
            ->join("exam_set_license_type", "exam_sets.ExamSetID", "=", "exam_set_license_type.ExamSetID")
            ->join("license_types", "license_types.LicenseTypeID", "=", "exam_set_license_type.LicenseTypeID")
            ->whereIn("exam_set_license_type.LicenseTypeID", $licenseIDs)
            ->where("exam_sets.ExamSetName", $examSetName)
            ->where("exam_sets.ExamSetID", "!=", $id)
            ->distinct()
            ->pluck("license_types.LicenseTypeName");
        if ($existing->count() > 0) {
            $list = $existing->implode(", ");
            return back()->with("exists_exam", "$examSetName đã tồn tại đối với  $list");
        } else {
            $updateExs = ExamSet::find($id);
            $updateExs->update($validate);
            if (isset($licenseIDs)) {
                $updateExs->licenseType_Examset()->sync($licenseIDs);
            }
            return redirect()->route("admintrafficbot.examset")->with("update_success", "cập nhật $examSetName thành công");
        }
    }

    public function showExamSet(string $id)
    {
        $ExamSetID = ExamSet::find($id);
        $questions = $ExamSetID->question_ExamSet()->paginate(10);
        return view("admin.examSetManagement.showExamSet", compact("ExamSetID","questions"));
    }


}