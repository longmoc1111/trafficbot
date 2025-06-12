<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SignageType;
class Signage extends Model
{
    protected $primaryKey = "SignageID";
    protected $fillable = ["SignageID","SignageName","SignageImage","SignagesExplanation","SignageTypeID"];
    public function signage_SignageType(){
        return $this->belongsTo(SignageType::class, "SignageTypeID","SignageTypeID");
    }   
}
