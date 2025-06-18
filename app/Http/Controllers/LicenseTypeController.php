<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LicenseType;
use Illuminate\Support\Facades\DB;
use Validator;

class LicenseTypeController extends Controller
{
    public function listLicenseType()
    {
        $ListLicenseType = LicenseType::all();
        return view("admin.licenseManagement.listLicenseType", compact("ListLicenseType"));
    }
    public function createLicenseType()
    {
        return view("admin.licenseManagement.createLicenseType");
    }
    public function storeLicenseType(Request $request)
    {

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
        LicenseType::create($validator->validated());
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
    public function editLicenseType(string $id)
    {
        $editLicenseType = LicenseType::find($id);
        return view("admin.licenseType.editLicenseType", compact("editLicenseType"));
    }
    public function updateLicenseType(Request $request, string $id)
    {
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
            return back()->withErrors($validator, "edit");
        }
        $validatedata = $validator->validated();
        $license = LicenseType::find($id);
        $license->update($validatedata);
        return redirect()->route("admintrafficbot.listlicensetype")->with("update_license", "cập nhật giấy phép thành công !");

    }
}

