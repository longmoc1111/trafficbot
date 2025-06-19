<?php

namespace App\Http\Controllers;

use App\Models\QuestionCategory;
use Illuminate\Http\Request;
use App\Models\LicenseType;
use Illuminate\Support\Facades\DB;
use Validator;

class LicenseTypeController extends Controller
{
    public function listLicenseType()
    {
        $ListLicenseType = LicenseType::with("questionCategory_LicenseType")->get();
        return view("admin.licenseManagement.listLicenseType", compact("ListLicenseType"));
    }
    public function createLicenseType()
    {
        $QuestionCategory = QuestionCategory::all();
        return view("admin.licenseManagement.createLicenseType", compact("QuestionCategory"));
    }
    public function storeLicenseType(Request $request)
    {

        $categories = $request->input("questionCategory");
        $sysData = [];
        foreach ($categories as $ID => $quantity) {
            if ($quantity > 0) {
                $sysData[$ID] = ["Quantity" => $quantity];
            }
        }
        $validator = Validator::make(
            $request->all(),
            [
                "LicenseTypeName" => "required|unique:license_types,LicenseTypeName",
                "LicenseTypeDescription" => "required",
                "LicenseTypeDuration" => "required|numeric",
                "LicenseTypeQuantity" => "required|numeric",
                "LicenseTypePassCount" => "required|numeric",
            ],
            [
                "LicenseTypeName.required" => "vui lòng không để trống !",
                "LicenseTypeName.unique" => "Giấy phép này đã tồn tại, vui lòng nhập tên khác !",
                "LicenseTypeDescription.required" => "vui lòng không để trống !",
                "LicenseTypeDuration.required" => "vui lòng không để trống !",
                "LicenseTypeDuration.numeric" => "Dữ liệu phải là số !",
                "LicenseTypeQuantity.required" => "vui lòng không để trống !",
                "LicenseTypeQuantity.numeric" => "Dữ liệu phải là số !",
                "LicenseTypePassCount.required" => "vui lòng không để trống !",
                "LicenseTypePassCount.numeric" => "Dữ liệu phải là số !",

            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator, "create");
        }
        $validatedData = $validator->validated();
        $licenseTypeName = $validatedData["LicenseTypeName"];
        $LicenseType = LicenseType::create($validator->validated());
        if ($LicenseType) {
            $LicenseType->questionCategory_LicenseType()->sync($sysData);
        }
        return redirect()->route("admintrafficbot.listlicensetype")->with("add_license", "Thêm mới $licenseTypeName thành công");

    }
    public function deleteLicenseType($ID)
    {
        $licenseType = LicenseType::find($ID);
        $licenseTypeName = $licenseType->LicenseTypeName;
        if (isset($licenseType)) {
            $licenseType->examset_LicenseType()->detach();
            $licenseType->question_LicenseType()->detach();
        }
        $licenseType->delete();
        return redirect()->route("admintrafficbot.listlicensetype")->with("delete_license", "xóa $licenseTypeName thành công  !");
    }
    public function editLicenseType($ID)
    {
        $editLicenseType = LicenseType::with("questionCategory_LicenseType")->find($ID);
        $categoryQuantity = $editLicenseType->questionCategory_LicenseType
            ->pluck("pivot.Quantity", "CategoryID")
            ->toArray();
        $questionCategory = QuestionCategory::all();
        return view("admin.licenseManagement.editLicenseType", compact("editLicenseType", "questionCategory", "categoryQuantity"));
    }
    public function updateLicenseType(Request $request, $ID)
    {

        $categories = $request->input("questionCategory", []);
        $datasync = [];
        foreach ($categories as $index => $item) {
            if ($item != null) {
                $datasync[$index] = ["Quantity" => $item];
            }
        }
        $validator = Validator::make(
            $request->all(),
            [
                "LicenseTypeName" => "required|unique:license_types,LicenseTypeName,{$ID},LicenseTypeID",
                "LicenseTypeDescription" => "required",
                "LicenseTypeDuration" => "required|numeric",
                "LicenseTypeQuantity" => "required|numeric",
                "LicenseTypePassCount" => "required|numeric",

            ],
            [
                "LicenseTypeName.required" => "vui lòng không để trống !",
                "LicenseTypeName.unique" => "Giấy phép này đã tồn tại, vui lòng nhập tên khác !",
                "LicenseTypeDescription.required" => "vui lòng không để trống !",
                "LicenseTypeDuration.required" => "vui lòng không để trống !",
                "LicenseTypeDuration.numeric" => "Dữ liệu phải là số !",
                "LicenseTypeQuantity.required" => "vui lòng không để trống !",
                "LicenseTypeQuantity.numeric" => "Dữ liệu phải là số !",
                "LicenseTypePassCount.required" => "vui lòng không để trống !",
                "LicenseTypePassCount.numeric" => "Dữ liệu phải là số !",

            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator, "edit");
        }
        $validatedata = $validator->validated();
        $license = LicenseType::find($ID);
        if ($license) {
            $license->update($validatedata);
            $license->questionCategory_LicenseType()->sync($datasync);
        return redirect()->route("admintrafficbot.listlicensetype")->with("update_license", "cập nhật giấy phép thành công !");

        }else{
        return redirect()->route("admintrafficbot.listlicensetype")->with("update_fails", "cập nhật giấy phép thất bại !");

        }


    }
}

