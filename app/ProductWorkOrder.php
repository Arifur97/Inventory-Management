<?php

namespace App;

use App\Ordertype;
use Illuminate\Database\Eloquent\Model;

class ProductWorkOrder extends Model
{
    protected $table = 'product_work_order';
    protected $fillable =[
        "work_order_id", "product_id", "product_code", "variant_id", "work_order_unit_id", "qty", "base_image", "order_type", "color", "size", "description", "note"
    ];

    public function ordertype() {
        return $this->belongsTo(Ordertype::class, 'order_type');
    }
}

