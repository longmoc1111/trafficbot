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
        $dataList = ChatBot::orderBy("created_at", "ASC")->paginate(10);
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
                "File" => "required|mimes:pdf|max:5120"
            ], [
                "DocumentName.required" => "Không được để trống!",
                "DocumentDesciption.required" => "Không được để trống!",
                "File.required" => "Bạn phải chọn file updload!",
                "File.max" => "file vượt quá 5MB!",
                "File.mimes" => "File phải có định dạng là PDF!",
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator, "create_file")->withInput();
            }
            $data = [
                "DocumentName" => $request->DocumentName,
                "DocumentDesciption" => $request->DocumentDesciption,
                "CategoryID" => $dataID,
            ];
            if ($request->hasFile("File")) {
                $file = $request->file("File");
                $fileNameWithoutExt = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $fileNameExt = $file->getClientOriginalExtension();
                $newFileName = $fileNameWithoutExt . "_" . time() . "." . $fileNameExt;
                $data["File"] = $newFileName;
                $file->move(storage_path("app/public/filePDF"), $newFileName);
            }
            $createData = ChatBot::create($data);
            if ($createData) {
                return redirect()->route("admintrafficbot.chatbot")->with("create_success", "thêm mới file thành công !");
            } else {
                return redirect()->route("admintrafficbot.chatbot")->with("create_fail", "Đã có lỗi xãy ra hay thử tạo lại sau!");
            }
        } else if ($dataType->CategoryName == "URL") {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                "URLName" => "required",
                "LinkURL" => "required|url",
                "DescriptionURL" => "required",
                "selectorURL" => "required"
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
                "DocumentName" => $request->URLName,
                "DocumentDesciption" => $request->DescriptionURL,
                "LinkURL" => $request->LinkURL,
                "CategoryID" => $dataID,
                "SelectorURL" => $request->selectorURL
            ];
            $createData = ChatBot::create($data);
            if ($createData) {
                return redirect()->route("admintrafficbot.chatbot")->with("create_success", "thêm mới URL thành công !");
            } else {
                return redirect()->route("admintrafficbot.chatbot")->with("create_fail", "Đã có lỗi xãy ra hay thử tạo lại sau!");
            }
        }
    }

    public function updateChatBot($ID, Request $request)
    {
        //   dd($request->all());
        $chatbot = ChatBot::find($ID);
        $dataID = request("DataType");
        $data = [];
        $dataType = ChatCategory::where("CategoryID", $dataID)->first();
        if ($dataType->CategoryName == "PDF") {
            $validator = Validator::make($request->all(), [
                "DocumentName" => "required",
                "DocumentDesciption" => "required",
                "File" => "max:5120"
            ], [
                "DocumentName.required" => "Không được để trống!",
                "DocumentDesciption.required" => "Không được để trống!",
                "File.max" => "file vượt quá 5MB!",
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator, "update_file")->withInput()->with("edit_chatbotID", $chatbot->ChatbotID);
            }
            $data = [
                "DocumentName" => $request->DocumentName,
                "DocumentDesciption" => $request->DocumentDesciption,
                "CategoryID" => $dataID,
            ];
            if ($request->hasFile("File")) {
                if ($request->get("oldFile")) {
                    $oldfile = storage_path("app/public/filePDF/" . $request->get("oldFile"));
                    if (File::exists($oldfile)) {
                        File::delete($oldfile);
                    }
                }
                $file = $request->file("File");
                $fileNameWithoutExt = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $fileNameExt = $file->getClientOriginalExtension();
                $newFileName = $fileNameWithoutExt . "_" . time() . "." . $fileNameExt;
                $data["File"] = $newFileName;
                $file->move(storage_path("app/public/filePDF"), $newFileName);
            }
            $updateData = $chatbot->update($data);
            if ($updateData) {
                return redirect()->route("admintrafficbot.chatbot")->with("update_success", "cập nhật file thành công !");
            } else {
                return redirect()->route("admintrafficbot.chatbot")->with("update_fail", "Đã có lỗi xãy ra hay thử lại sau!");
            }
        }else if ($dataType->CategoryName == "URL") {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                "URLName" => "required",
                "LinkURL" => "required|url",
                "DescriptionURL" => "required",
                "selectorURL" => "required"
            ], [
                "URLName.required" => "Không được để trống!",
                "LinkURL.required" => "Không được để trống!",
                "LinkURL.url" => "Hãy nhập đúng định dang url!",
                "DescriptionURL.required" => "Không được để trống!",
                "selectorURL.required" => "Không được để trống!",


            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator, "update_url")->withInput()->with("edit_chatbotID", $chatbot->ChatbotID);
            }
            $data = [
                "DocumentName" => $request->URLName,
                "DocumentDesciption" => $request->DescriptionURL,
                "LinkURL" => $request->LinkURL,
                "CategoryID" => $dataID,
                "SelectorURL" => $request->selectorURL
            ];
            $createData = $chatbot->update($data);
            if ($createData) {
                return redirect()->route("admintrafficbot.chatbot")->with("update_success", "Cập nhật URL thành công !");
            } else {
                return redirect()->route("admintrafficbot.chatbot")->with("update_fail", "Đã có lỗi xãy ra hay thử lại sau!");
            }
        }


    }

    public function deleteChatBot($ID)
    {
        $datalist = ChatBot::find($ID);
        $FileName = $datalist->File;
        if ($FileName) {
            $file = storage_path("app/public/filePDF/" . $FileName);
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
