<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSupplierQuotation extends Model
{
    protected $table = 'product_supplier_quotations';
    protected $fillable =[
        
        "purchase_quotation_id", "product_id", "variant_id", "qty", "recieved", "purchase_unit_id", "net_unit_cost", "discount", "tax_rate", "tax", "total", "p_note"
    ];
}
