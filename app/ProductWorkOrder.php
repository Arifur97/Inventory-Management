<?php

namespace App;

use App\Ordertype;
use App\Product;
use App\Color;
use App\Size;
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

    public function product() {
        return $this->belongsTo(Product::class, 'product_id')->with('category');
    }

    public function color() {
        return $this->belongsTo(Color::class, 'color');
    }

    public function size() {
        return $this->belongsTo(Size::class, 'size');
    }
}

