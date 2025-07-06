<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ChatBot;

class ChatCategory extends Model
{
    protected $primaryKey = "CategoryID";
    public $fillable = ["CategoryID", "CategoryName"];

    public function chatbot_Category(){
        return $this->hasMany(ChatBot::class, "CategoryID", "CategoryID");
    }
}
