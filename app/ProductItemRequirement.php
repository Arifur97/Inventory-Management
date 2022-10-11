<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductItemRequirement extends Model
{
    protected $table = 'product_item_requirements';
    protected $fillable =[

        "item_requirement_id", "product_id", "variant_id", "qty", "recieved", "unit_id", "pnote"
    ];
}
