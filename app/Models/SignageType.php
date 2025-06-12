<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\signage;
class SignageType extends Model
{
    protected $primaryKey = "SignageTypeID";
    protected $fillable = ["SignageTypeID","SignagesTypeName","SignagesTypeDescription"];
    public function signageType_signage(){
        return $this->hasMany(signage::class, "SignageTypeID","SignageTypeID");
    }

}
