<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatBot extends Model
{
    protected $primaryKey = "ChatbotID";
    public $fillable = ["ChatbotID", "FileName","FileDesciption", "File"];

}
