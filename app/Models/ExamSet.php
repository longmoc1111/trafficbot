<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LicenseType;
use App\Models\Question;


class ExamSet extends Model
{   
    public $fillable = ["ExamSetID","ExamSetName"];
    protected $primaryKey = "ExamSetID";

    public function licenseType_Examset(){
        return $this->belongsToMany(LicenseType::class, "exam_set_license_type","ExamsetID","LicenseTypeID");
    }
    public function question_Examset(){
        return $this->belongsToMany(Question::class,"question_exam_sets","ExamSetID","QuestionID")
         ->withTimestamps()
         ->withPivot("QuestionExamsetID")
          ->orderBy('QuestionExamsetID'); ;
    }
}
