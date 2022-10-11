<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountTypes extends Model
{
    protected $table = "account_types";

    protected $fillable =[
        "account_type", "is_active"
    ];
}
