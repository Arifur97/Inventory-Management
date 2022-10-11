<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable =[
        "name", "description", "guard_name", "shortcut_form_id", "is_active"
    ];
}
