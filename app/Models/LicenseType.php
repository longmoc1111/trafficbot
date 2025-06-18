<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ExamSet;
use App\Models\Question;
use App\Models\ExamResult;


class LicenseType extends Model
{
    public $fillable = ["LicenseTypeID","LicenseTypeName","LicenseTypeDescription"];
    protected $primaryKey = "LicenseTypeID";
    
    public function examset_LicenseType(){
        return $this->belongsToMany(ExamSet::class, "exam_set_license_type","LicenseTypeID","ExamSetID");
    }
    public function question_LicenseType(){
        return $this->belongsToMany(Question::class,"question_license_types","LicenseTypeID","QuestionID");
    }
    public function result_LicenseType(){
        return $this->hasMany(ExamResult::class , "LicenseTypeID","LicenseTypeID");
    }
}
