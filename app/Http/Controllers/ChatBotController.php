<?php

namespace App\Http\Controllers;

use App\Models\ChatBot;
use App\Models\ChatCategory;
use File;
use Illuminate\Http\Request;
use Validator;


class ChatBotController extends Controller
{
    public function dataList()
    {
        $dataList = ChatBot::orderBy("created_at","ASC")->paginate(10);
        $categories = ChatCategory::all();
        $optionFile = ChatCategory::where("CategoryName", "PDF")->first();
        $optionURL = ChatCategory::where("CategoryName", "URL")->first();
        return view("admin.chatBotManagement.dataList", compact("dataList", "optionFile", "optionURL"));
    }
    public function storeChatBot(Request $request)
    {
        $dataID = request("DataType");
        $data = [];
        $dataType = ChatCategory::where("CategoryID", $dataID)->first();
        if ($dataType->CategoryName == "PDF") {
            $validator = Validator::make($request->all(), [
                "DocumentName" => "required",
                "DocumentDesciption" => "required",
                "File" => "required|mimes:pdf|max:8096"
            ], [
                "DocumentName.required" => "Không được để trống!",
                "DocumentDesciption.required" => "Không được để trống!",
                "File.required" => "Bạn phải chọn file updload!",
                "File.max" => "file vượt quá 2MB!",
                "File.mimes" => "File phải có định dạng là PDF!",
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator, "create_file")->withInput();
            }
            $data = [
                "DocumentName"=> $request->DocumentName,
                "DocumentDesciption"=> $request->DocumentDesciption,
                "CategoryID"=>$dataID,
            ];
            if($request->hasFile("File")){
                $file = $request->file("File");
                $fileNameWithoutExt = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $fileNameExt = $file->getClientOriginalExtension();
                $newFileName = $fileNameWithoutExt. "_". time() . ".".$fileNameExt;
                $data["File"] = $newFileName;
                $file->move(storage_path("app/public/filePDF"), $newFileName);
            }
            $createData = ChatBot::create($data);
            if($createData){
                return redirect()->route("admintrafficbot.chatbot")->with("create_success", "thêm mới file thành công !");
            }else{
                return redirect()->route("admintrafficbot.chatbot")->with("create_fail", "Đã có lỗi xãy ra hay thử tạo lại sau!");
            }
        } else if ($dataType->CategoryName == "URL") {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                "URLName" => "required",
                "LinkURL" => "required|url",
                "DescriptionURL" => "required",
                "selectorURL"=>"required"
            ], [
                "URLName.required" => "Không được để trống!",
                "LinkURL.required" => "Không được để trống!",
                "LinkURL.url" => "Hãy nhập đúng định dang url!",
                "DescriptionURL.required" => "Không được để trống!",
                "selectorURL.required" => "Không được để trống!",


            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator, "create_url")->withInput();
            }
            $data = [
                "DocumentName"=> $request->URLName,
                "DocumentDesciption"=>$request->DescriptionURL,
                "LinkURL"=>$request->LinkURL,
                "CategoryID"=>$dataID,
                "SelectorURL"=>$request->selectorURL
            ];
                 $createData = ChatBot::create($data);
            if($createData){
                return redirect()->route("admintrafficbot.chatbot")->with("create_success", "thêm mới URL thành công !");
            }else{
                return redirect()->route("admintrafficbot.chatbot")->with("create_fail", "Đã có lỗi xãy ra hay thử tạo lại sau!");
            }
        }

        // $validator = Validator::make($request->all(), [
        //     "FileName" => "required",
        //     "FileDesciption" => "required",
        //     "File" => "required|mimes:pdf"
        // ], [
        //     "FileName.required" => "Không được để trống!",
        //     "FileDesciption.required" => "Không được để trống!",
        //     "File.required" => "Bạn phải chọn file updload!",
        //     "File.mimes" => "File phải có định dạng là PDF!",

        // ]);
        // if ($validator->fails()) {
        //     return back()->withErrors($validator, "create");
        // }
        // $validate = $validator->validated();

        // if ($request->hasFile("File")) {
        //     $file = $request->file("File");
        //     $fileWithoutExt = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        //     $fileNameExt = $file->getClientOriginalExtension();
        //     $newFileName = $fileWithoutExt . "_" . time() . "." . $fileNameExt;
        //     $validate["File"] = $newFileName;
        //     $file->move(public_path("assets/chatbot/data"), $newFileName);
        // }

        // $dataFile = ChatBot::create($validate);
        // if ($dataFile) {
        //     return redirect()->route("admintrafficbot.chatbot")->with("create_success", "Thêm mới dữ liệu thành công");
        // } else {
        //     return redirect()->route("admintrafficbot.chatbot")->with("create_fails", "Thêm mới dữ liệu không thành công");

        // }
    }

    public function updateChatBot($ID, Request $request)
    {
        $rules = [
            "FileName" => "required",
            "FileDesciption" => "required",
        ];
        if (!$request->get("oldFile")) {
            $rules["File"] = "required|mimes:pdf";
        }
        $validator = Validator::make(
            $request->all(),
            $rules,
            [
                "FileName.required" => "Không được để trống!",
                "FileDesciption.required" => "Không được để trống!",
                "File.required" => "Bạn phải chọn file updload!",
                "File.mimes" => "File phải có định dạng là PDF!",
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator, "update");
        }
        $validate = $validator->validated();

        if ($request->hasFile("File")) {
            if ($request->get("oldFile")) {
                $oldFile = public_path("/assets/chatbot/data/" . $request->get("oldFile"));
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }
            $file = $request->file("File");
            $fileWithoutExt = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileNameExt = $file->getClientOriginalExtension();
            $newFileName = $fileWithoutExt . "_" . time() . "." . $fileNameExt;
            $validate["File"] = $newFileName;
            $file->move(public_path("assets/chatbot/data"), $newFileName);
        }

        $datalist = ChatBot::find($ID);
        if ($datalist) {
            $datalist->update($validate);
            return redirect()->route("admintrafficbot.chatbot")->with("update_success", "Cập nhật dữ liệu thành công");
        } else {
            return redirect()->route("admintrafficbot.chatbot")->with("update_fails", "Cập nhật dữ liệu không thành công");
        }



    }

    public function deleteChatBot($ID)
    {
        $datalist = ChatBot::find($ID);
        $FileName = $datalist->File;
        if ($FileName) {
            $file = storage_path("app/public/filePDF/".$FileName);
            if (File::exists($file)) {
                File::delete($file);
            }
        }
        if ($datalist) {
            $datalist->delete();
            return redirect()->route("admintrafficbot.chatbot")->with("delete_success", "xóa dữ liệu thành công");
        } else {
            return redirect()->route("admintrafficbot.chatbot")->with("delete_fails", "xóa dữ liệu không thành công");
        }
    }
}
