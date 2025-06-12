<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    const ADMIN = 1;
    const USER = 2;
    protected $fillable = ["roleID","roleName"];
    protected $primaryKey = "roleID";
    public function user_Role(){
        return $this->hasMany(User::class, "roleID","roleID");
    }
}
