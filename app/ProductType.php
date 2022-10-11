<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = 'producttypes';
    protected $fillable =[
        "name", "is_active"
    ];
    
}
