<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable=['name','email','password','mobile','role'];
    protected $attributes=['otp'=>'0'];
}
