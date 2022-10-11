<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YesNo extends Model
{
    protected $table = 'yesnos';
    protected $fillable =[
        "yes_no", "is_active"
    ];
}
