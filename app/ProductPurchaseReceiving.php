<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPurchaseReceiving extends Model
{
    protected $table = 'product_purchase_receivings';
    protected $fillable =[

        "purchase_receiving_id", "product_id", "variant_id", "name", "code", "qty", "received", "unit_id"
    ];
}
