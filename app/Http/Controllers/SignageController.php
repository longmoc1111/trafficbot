<?php

namespace App\Http\Controllers;
use App\Models\Signage;
use File;
use Illuminate\Http\Request;
use App\Models\SignageType;
use Validator;
use function Laravel\Prompts\search;

class SignageController extends Controller
{

    //loại biển báo
    public function listSignageTypes()
    {
        $signagesType = SignageType::OrderBy("created_at", "ASC")->paginate(10);
        return view("admin.signagesManagement.listSignagesTypes", compact("signagesType"));
    }

    public function searchSignageTypes()
    {
        $key = request("search");
        if ($key && trim($key) != null) {
            $signagesType = SignageType::where("SignagesTypeName", "like", "%" . $key . "%")
                ->orWhere("SignagesTypeDescription", "like", "%" . $key . "%")
                ->paginate(10)->appends(request()->query());
            return view("admin.signagesManagement.listSignagesTypes", compact("signagesType"));
        } else {
            $signagesType = SignageType::OrderBy("created_at", "ASC")->paginate(10);
            return view("admin.signagesManagement.listSignagesTypes", compact("signagesType"));
        }
    }
    // public function createSignageTypes()
    // {
    //     return view("admin.signagesManagement.signagesTypes.createSignagesTypes");
    // }
    public function storeSignageTypes(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                "SignagesTypeName" => "required",
                "SignagesTypeDescription" => "required"
            ],
            [
                "SignagesTypeName.required" => "Không được để trống!",
                "SignagesTypeDescription.required" => "không được để trông!",
            ]
        );
        if($validator->fails()){
            return back()->withErrors($validator,"create")->withInput();
        }
        $signages = SignageType::create($validator->validated());
        if ($signages) {
            return redirect()->route("admintrafficbot.listsignagetypes")->with("create_success", "Thêm mới loại biển báo thành công!");
        } else {
            return redirect()->route("admintrafficbot.listsignagetypes")->with("create_fails", "Đã có lỗi xảy ra - vui lòng thêm mới sau !");
        }
    }
    public function updateSignageTypes($ID, Request $request)
    {
        $validate = $request->validate(
            [
                "SignagesTypeName" => "required",
                "SignagesTypeDescription" => "required"
            ],
            [
                "SignagesTypeName.required" => "Không được để trống!",
                "SignagesTypeDescription.required" => "không được để trông!",
            ]
        );
        $signages = SignageType::find($ID);
        if ($signages) {
            $signages->update($validate);
            if ($signages) {
                return redirect()->route("admintrafficbot.listsignagetypes")->with("update_success", "cập nhật biển báo thành công!");
            } else {
                return redirect()->route("admintrafficbot.listsignagetypes")->with("update_fails", "Đã có lỗi xảy ra - vui lòng cập nhật lại sau !");
            }
        }
    }

    public function deleteSignageTypes($ID)
    {
        $signageType = SignageType::find($ID);
        if ($signageType) {
            foreach($signageType->signageType_signage as $signage){
                $signage->update(["SignageTypeID" => null]);
            };
            $signageType->delete();

            return redirect()->route("admintrafficbot.listsignagetypes")->with("delete_success", "xóa loại biển báo thành công!");
        } else {
            return redirect()->route("admintrafficbot.listsignagetypes")->with("delete_fails", "Đã có lỗi xảy ra - vui lòng xóa lại sau !");

        }
    }



    //end loại biển báo


    //biển báo
    public function listSignages()
    {
        $signageTypes = SignageType::all();
        $option = request("option");
        if ($option) {
            $signages = Signage::where("SignageTypeID", "like", "%" . $option . "%")->OrderBy("created_at", "asc")->paginate(10);
            return view("admin.signagesManagement.listSignages", compact("signages", "signageTypes", "option"));
        } else {
            $signages = Signage::OrderBy("created_at", "asc")->paginate(10);
            return view("admin.signagesManagement.listSignages", compact("signages", "signageTypes", "option"));
        }

    }

    public function searchSignage()
    {
        $signageTypes = SignageType::all();
        $key = request("search");
        if ($key && trim($key) != null) {
            $signages = Signage::where("SignageName", "like", "%" . $key . "%")
                ->orWhere("SignagesExplanation", "like", "%" . $key . "%")->paginate(10)->appends(request()->query());
            return view("admin.signagesManagement.listSignages", compact("signages", "signageTypes"));
        } else {
            $signages = Signage::OrderBy("created_at", "asc")->paginate(10);
            return view("admin.signagesManagement.listSignages", compact("signages", "signageTypes"));
        }
    }
    // public function createSignages()
    // {
    //     $signagesTypes = SignageType::all();
    //     return view("admin.signagesManagement.signages.createSignages", compact("signagesTypes"));
    // }
    public function storeSignages(Request $request)
    {

        $validate = $request->validate([
            "SignageName" => "required",
            "SignageTypeID" => "required",
            "SignageImage" => "required",
            "SignagesExplanation" => "required"
        ], [
            "SignageTypeID.required" => "Không đươc để trống!",
            "SignageName.required" => "Không được để trống!",
            "SignageImage.required" => "Không được để trống!",
            "SignagesExplanation.required" => "Không được để trống"
        ]);

        if ($request->hasFile("SignageImage")) {
            $file = $request->file("SignageImage");
            $fileNameWithoutExt = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileNameExt = $file->getClientOriginalExtension();
            $newFileName = $fileNameWithoutExt . "_" . time() . "." . $fileNameExt;
            $file->move(storage_path("app/public/uploads/imageSignage"), $newFileName);
            $validate["SignageImage"] = $newFileName;
        }
        if ($validate) {
            $signage = Signage::create($validate);
            if ($signage) {
                return redirect()->route("admintrafficbot.listsignages")->with("create_success", "Thêm mới biển báo thành công!");
            } else {
                return redirect()->route("admintrafficbot.listsignages")->with("create_fails", "Đã có lỗi xảy ra, vui lòng thêm mới sau!");

            }
        }

    }
    public function deleteSignages($ID)
    {
        $signage = Signage::find($ID);
        if ($signage) {
            $signage->delete();
            return redirect()->route("admintrafficbot.listsignages")->with("delete_success", "xóa biển báo thành công!");
        } else {
            return redirect()->route("admintrafficbot.listsignages")->with("delete_fails", "Xóa không thành công, vui lòng thử lại sau!");
        }
    }

    public function updateSignages($ID, Request $request)
    {
    

        $validate = $request->validate(
            [
                "SignageTypeID" => "required",
                "SignageName" => "required",
                "SignagesExplanation" => "required"
            ],
            [
                "SignageTypeID.required" => "Không được để trống!",
                "SignageName.required" => "Không được để trống!",
                "SignagesExplanation.required" => "Không được để trống!",
            ]
        );
        if ($request->hasFile("NewImage")) {

            if ($request->get("OldImage")) {
                $oldfile = storage_path("app/public/uploads/imageSignage" . $request->get("OldImage"));
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }
            $file = $request->file("NewImage");
            $fileNameWithoutExt = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileNameExt = $file->getClientOriginalExtension();
            $newFileName = $fileNameWithoutExt . "_" . time() . "." . $fileNameExt;
     
            $file->move(storage_path("app/public/uploads/imageSignage"),$newFileName);
            $validate["SignageImage"] = $newFileName;

        }
        $signage = Signage::find($ID);
        if ($signage) {
            $signage->update($validate);
            return redirect()->route("admintrafficbot.listsignages")->with("update_success", "Cập nhật biển báo thành công!");
        } else {
            return redirect()->route("admintrafficbot.listsignages")->with("update_fails", "Cập nhật biển báo không thành công, vui lòng thử lại sau!");

        }
    }



    //end biển báo
}
