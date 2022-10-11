<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $fillable =[
        "designation_name", "department_id", "is_active"
    ];
}
