<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\LicenseType;

class ExamResult extends Model
{
    protected $primaryKey = "ResultID";
    public $fillable = ["ResultID", "userID","LicenseTypeID","score","passed","duration"];
    public function licenseType_Result(){
        return $this->belongsTo(LicenseType::class , "LicenseTypeID", "LicenseTypeID");
    }
    public function user_Result(){
        return $this->belongsTo(User::class, "userID", "userID");
    }
}
