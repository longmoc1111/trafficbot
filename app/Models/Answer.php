<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public $fillable = ["AnswerID","AnswerLabel","AnswerName","IsCorrect","QuestionID"];
    protected $primaryKey = "AnswerID";
    public function answer_Question(){
        return $this->belongsTo(question::class,"QuestionID","QuestionID");
    }
}
