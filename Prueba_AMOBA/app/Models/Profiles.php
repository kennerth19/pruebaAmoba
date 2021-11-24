<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    protected $table = 'profile';
    protected $fillable = ['ima_profile'];
    protected $guarded = ['id','User_id'];
}
