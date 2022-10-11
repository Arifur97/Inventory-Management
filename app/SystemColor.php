<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemColor extends Model
{
    protected $fillable =[
        "color", "is_active"
    ];
}
