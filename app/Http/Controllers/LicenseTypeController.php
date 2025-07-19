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
        $ListLicenseType = LicenseType::with("questionCategory_LicenseType")->paginate(10);
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
        $sum = 0;
        if ($categories) {
            foreach ($categories as $ID => $quantity) {
                if ($quantity > 0) {
                    $sysData[$ID] = ["Quantity" => $quantity];
                    $sum += $quantity;
                }
            }
        } else {
            $sysData = [];
        }
        $validator = Validator::make(
            $request->all(),
            [
                "LicenseTypeName" => "required|unique:license_types,LicenseTypeName",
                "LicenseTypeDescription" => "required",
                "LicenseTypeDuration" => "required|numeric",
                "LicenseTypeQuantity" => "required|numeric",
                "LicenseTypePassCount" => "required|numeric|lt:LicenseTypeQuantity",
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
                "LicenseTypePassCount.lt" => "Số lượng câu đúng tối thiểu phải nhỏ hơn số lượng câu hỏi!",


            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator, "create")->withInput();
        }

        $validatedData = $validator->validated();
        if($sum >= $validatedData["LicenseTypeQuantity"]){
            $validateQuantity =  $validatedData['LicenseTypeQuantity'];
            return back()->withErrors(["sum_questionCategory"=>"Tổng sô lượng loại câu hỏi không được vượt quá $validateQuantity câu"]);
        }
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
            $licenseType->questionCategory_LicenseType()->detach();
            $licenseType->result_LicenseType()->delete();
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
         $sum = 0;
        foreach ($categories as $index => $item) {
            if ($item != null) {
                $datasync[$index] = ["Quantity" => $item];
                $sum += $item;
            }
        }
        $validator = Validator::make(
            $request->all(),
            [
                "LicenseTypeName" => "required|unique:license_types,LicenseTypeName,{$ID},LicenseTypeID",
                "LicenseTypeDescription" => "required",
                "LicenseTypeDuration" => "required|numeric",
                "LicenseTypeQuantity" => "required|numeric",
                "LicenseTypePassCount" => "required|numeric|lt:LicenseTypeQuantity",
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
                 "LicenseTypePassCount.lt" => "Số lượng câu đúng tối thiểu phải nhỏ hơn số lượng câu hỏi!",

            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator, "edit");
        }
        $validatedata = $validator->validated();
         if($sum >= $validatedata["LicenseTypeQuantity"]){
            $validateQuantity =  $validatedata['LicenseTypeQuantity'];
            return back()->withErrors(["sum_questionCategory"=>"Tổng sô lượng loại câu hỏi không được vượt quá $validateQuantity câu"]);
        }
        $license = LicenseType::find($ID);
        if ($license) {
            $license->update($validatedata);
            $license->questionCategory_LicenseType()->sync($datasync);
            return redirect()->route("admintrafficbot.listlicensetype")->with("update_license", "cập nhật giấy phép thành công !");

        } else {
            return redirect()->route("admintrafficbot.listlicensetype")->with("update_fails", "cập nhật giấy phép thất bại !");

        }


    }
}

