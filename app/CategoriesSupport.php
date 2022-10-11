<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriesSupport extends Model
{
    protected $table = "categories_support";

    protected $fillable =[
        "name"
    ];
}
