<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatBot extends Model
{
    protected $primaryKey = "ChatbotID";
    public $fillable = ["ChatbotID", "DocumentName","DocumentDesciption","LinkURL", "File","Content","CategoryID"];
    public function category_Chatbot(){
        return $this->belongsTo(ChatCategory::class, "CategoryID", "CategoryID");
    }
}



