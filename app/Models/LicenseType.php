<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ExamSet;
use App\Models\Question;
use App\Models\ExamResult;
use App\Models\QuestionCategory;



class LicenseType extends Model
{
    public $fillable = ["LicenseTypeID","LicenseTypeName","LicenseTypeDescription","LicenseTypeDuration","LicenseTypeQuantity","LicenseTypePassCount"];
    protected $primaryKey = "LicenseTypeID";
    
    public function examset_LicenseType(){
        return $this->belongsToMany(ExamSet::class, "exam_set_license_type","LicenseTypeID","ExamSetID");
    }
    public function question_LicenseType(){
        return $this->belongsToMany(Question::class,"question_license_types","LicenseTypeID","QuestionID")
                    ->withPivot("IsCritical");
    }
    public function result_LicenseType(){
        return $this->hasMany(ExamResult::class , "LicenseTypeID","LicenseTypeID");
    }
    public function questionCategory_LicenseType(){
        return $this->belongsToMany(QuestionCategory::class, "license_type_question_category", "LicenseTypeID", "CategoryID")
                    ->withPivot("Quantity");
    }
  
}
