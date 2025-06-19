<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\LicenseType;


class QuestionCategory extends Model
{
   public  $fillable = ["CategoryID","CategoryName"];
   protected $primaryKey = "CategoryID";
   public function question_QuestionCategory(){
    return $this->HasMany(Question::class,"CategoryID","CategoryID");
   }
       public function questionCategory_LicenseType(){
        return $this->belongsToMany(LicenseType::class, "license_type_question_category", "CategoryID","LicenseTypeID", )
                    ->withPivot("Quantity");
    }
}
