<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ordertype extends Model
{
    protected $fillable =[
        "order_type", "is_active"
    ];

}
