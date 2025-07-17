<?php

namespace App\Http\Controllers;

use App\Models\QuestionCategory;
use Illuminate\Http\Request;
use Validator;


class QuestionCategoryController extends Controller
{
    public function questionCategory()
    {
        $categories = QuestionCategory::orderBy("created_at", "ASC")->paginate(10);
        return view("admin.questionManagement.category.list", compact("categories"));
    }

    public function searchCategory()
    {
        $key = request("search");
        if ($key) {
            $categories = QuestionCategory::where("CategoryName", "like" , "%" . $key . "%")->paginate(10);
            return view("admin.questionManagement.category.list", compact("categories"));

        }
    }

    public function storeCategory(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                "CategoryName" => "required",
            ],
            [
                "CategoryName.required" => "Không được để trống!"
            ]
        );

        if ($validate->fails()) {
            return back()->withErrors($validate, "create")->withInput();
        }
        $Category = QuestionCategory::create($validate->validated());
        if ($Category) {
            return redirect()->route("admintrafficbot.question.category")->with("create_success", "Thêm mới loại câu hỏi thành công!");
        } else {
            return redirect()->route(route: "admintrafficbot.question.category")->with("create_fails", "Đã có lỗi xãy ra, hay thêm mới sau!");
        }
    }
    public function updateCategory($ID, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "CategoryName" => "required",
        ], [
            "CategoryName.required" => "Không được để trống!"
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator, "edit")->withInput();
        }
        $Category = QuestionCategory::find($ID);

        $Category->update($validator->validated());
        if ($Category) {
            return redirect()->route("admintrafficbot.question.category")->with("update_success", "Chỉnh sửa loại câu hỏi thành công!");
        } else {
            return redirect()->route("admintrafficbot.question.category")->with("update_fails", "Đã có lỗi xãy ra, vui lòng chỉnh sửa sau!");
        }
    }

    public function deleteCategory($ID)
    {
        $category = QuestionCategory::find($ID);
        $questions = $category->question_QuestionCategory()->get();
        if ($category) {
            foreach($questions as $question){
                $question->update([
                    "CategoryID" => null,
                ]);
            }
            $category->questionCategory_LicenseType()->detach();
            $category->delete();
            return redirect()->route("admintrafficbot.question.category")->with("delete_success", "Xóa loại câu hỏi thành công!");
        } else {
            return redirect()->route("admintrafficbot.question.category")->with("delete_fails", "Đã có lỗi xãy ra, vui lòng xóa lại sau!");
        }
    }

}
