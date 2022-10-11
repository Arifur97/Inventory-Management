<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProducSaleContract extends Model
{
    protected $table = 'product_sale_contracts';
    protected $fillable =[
        "sale_contract_id", "product_id", "product_batch_id", "variant_id", "qty", "sale_unit_id", "net_unit_price", "discount", "tax_rate", "tax", "total"
    ];
}
