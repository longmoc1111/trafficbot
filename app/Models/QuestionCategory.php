<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class QuestionCategory extends Model
{
   public  $fillable = ["CategoryID","CategoryName"];
   protected $primaryKey = "CategoryID";
   public function question_QuestionCategory(){
    return $this->HasMany(Question::class,"CategoryID","CategoryID");
   }
}
