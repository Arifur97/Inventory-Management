<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShelfLocation extends Model
{

    protected $table = 'product_shelf_location';

    protected $fillable =[

        "product_id", "variant_id", "warehouse_id", "position_A", "position_B", "position_C", "position_D", "note"
    ];

    public function supplier()
    {
    	return $this->belongsTo('App\Supplier');
    }

    public function warehouse()
    {
    	return $this->belongsTo('App\Warehouse');
    }

    public function variant()
    {
        return $this->belongsTo('App\Variant');
    }

    public function unit()
    {
    	return $this->belongsTo('App\Unit');
    }


    public function product()
    {
    	return $this->belongsTo('App\Product')->with('unit');
    }

}
