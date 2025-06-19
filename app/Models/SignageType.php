<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Signage;
class SignageType extends Model
{
    protected $primaryKey = "SignageTypeID";
    protected $fillable = ["SignageTypeID","SignagesTypeName","SignagesTypeDescription"];
    public function signageType_signage(){
        return $this->hasMany(Signage::class, "SignageTypeID","SignageTypeID");
    }

}
