<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LicenseType;
use Illuminate\Support\Facades\DB;
use Validator;

class LicenseTypeController extends Controller
{
    public function listLicenseType(){
        $ListLicenseType = LicenseType::all();
        return view("admin.licenseManagement.listLicenseType", compact("ListLicenseType"));
    }
    public function createLicenseType(){
        return view("admin.licenseManagement.createLicenseType");
    }
    public function storeLicenseType(Request $request){
        $validator = Validator::make($request->all(),[
            "LicenseTypeName"=>"required|unique:license_types,LicenseTypeName",
            "LicenseTypeDescription"=>"required"
        ],
        [
            "LicenseTypeName.required"=>"vui lòng không để trống !",
            "LicenseTypeName.unique"=>"Giấy phép này đã tồn tại, vui lòng nhập tên khác !",
            "LicenseTypeDescription.required"=>"vui lòng không để trống !"
        ]         
    );
    if($validator->fails()){
        return back()->withErrors($validator, "create");
    }
        $validatedData = $validator->validated();
        $licenseTypeName = $validatedData["LicenseTypeName"];
        LicenseType::create($validator->validated());
        return redirect()->route("admintrafficbot.listlicensetype")->with("add_license","Thêm mới $licenseTypeName thành công");
   
    }
    public function deleteLicenseType($ID){
        $licenseType = LicenseType::find($ID);
        $licenseTypeName = $licenseType->LicenseTypeName;
        if(isset($licenseType)){
            $licenseType->examset_LicenseType()->detach();
            $licenseType->question_LicenseType()->detach();
        }
        $licenseType->delete();
        return redirect()->route("admintrafficbot.listlicensetype")->with("delete_license","xóa $licenseTypeName thành công  !");
    }
    public function editLicenseType(String $id){
        $editLicenseType = LicenseType::find($id);
        return view("admin.licenseType.editLicenseType",compact("editLicenseType"));
    }
    public function updateLicenseType(Request $request, String $id){
        $validator = Validator::make($request->all(),[
            "LicenseTypeName"=>"required",
            "LicenseTypeDescription"=>"required",
        ],
        [
            "LicenseTypeName.required"=>"không được để trống !",
            "LicenseTypeName.unique"=>"Giấy phép này đã tồn tại!",
            "LicenseTypeDescription.required"=>"Không được để trống !"
        ]);
        if($validator->fails()){
            return back()->withErrors($validator, "edit");
        }
        $validatedata = $validator->validated();
        $license = LicenseType::find($id);
        $license->update($validatedata);
        return redirect()->route("admintrafficbot.listlicensetype")->with("update_license","cập nhật giấy phép thành công !");

    }
}

