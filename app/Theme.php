<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $table = "theme";

    protected $fillable = ["color1", "color2", "color3", "color4", "color5"];
}
