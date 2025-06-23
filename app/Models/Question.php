<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\QuestionCategory;
use App\Models\Answer;
use App\Models\ExamSet;


class Question extends Model
{
    public $fillable = ["QuestionID", "QuestionName", "ImageDescription", "QuestionExplain", "CategoryID"];
    protected $primaryKey = "QuestionID";
    public function categoryQuestion_Question()
    {
        return $this->belongsTo(QuestionCategory::class, "CategoryID", "CategoryID");
    }
    public function answer_Question()
    {
        return $this->hasMany(Answer::class, "QuestionID", "QuestionID");
    }
    public function licenseType_Question()
    {
        return $this->belongsToMany(LicenseType::class, "question_license_types", "QuestionID", "LicenseTypeID")
            ->withPivot("IsCritical");
    }
    public function examSet_Question()
    {
        return $this->belongsToMany(ExamSet::class, "question_exam_sets", "QuestionID", "ExamSetID");
    }
}
