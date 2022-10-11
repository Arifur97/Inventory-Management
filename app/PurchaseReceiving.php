<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseReceiving extends Model
{
    protected $fillable =[

        "reference_no","purchase_reference_no", "purchase_id", "warehouse_id", "supplier_id", "item", "total_qty", "paid_amount", "status", "purchase_status_id	", "documents", "note"
    ];

    public function supplier()
    {
    	return $this->belongsTo('App\Supplier');
    }
   
    public function warehouse()
    {
    	return $this->belongsTo('App\Warehouse');
    }
}
