<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $fillable = ['First_name','Last_name','Description','img'];
    protected $guarded = ['id'];

    public function scopeNombre($query, $nombre)
    {
        if($nombre)
        {
            return $query->where('nombre', 'LIKE', "%nombre%");
        }        
    }
}

