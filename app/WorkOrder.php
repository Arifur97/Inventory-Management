<?php

namespace App;

use App\ProductWorkOrder;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    protected $fillable =[
        "reference_no", "sales_reference_no", "sale_id", "user_id", "customer_id", "company_id", "delivery_location_id", "warehouse_id", "priority", "expected_date", "date", "stage", "work_order_status", "send_to", "document", "work_order_note", "staff_note"
    ];

    protected $appends = ['docs', 'order_type_tags'];

    public function biller()
    {
    	return $this->belongsTo('App\Biller');
    }

    public function customer()
    {
    	return $this->belongsTo('App\Customer');
    }

    public function Ordertype()
    {
    	return $this->belongsTo('App\Ordertype');
    }

    public function warehouse()
    {
    	return $this->belongsTo('App\Warehouse');
    }

    public function company()
    {
    	return $this->belongsTo('App\Company');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function documents() {
        return $this->belongsTo('App\Attachments', 'document');
    }

    public function getDocsAttribute() {
        return $this->documents->documents ?? '';
    }

    public function products() {
        return $this->hasMany(ProductWorkOrder::class)->with('ordertype');
    }

    public function getOrderTypeTagsAttribute() {
        $data = [];
        foreach($this->products as $product) {
            if(!in_array($product->ordertype->order_type, $data))
                $data[] = $product->ordertype->order_type;
        }

        return implode(', ', $data);
    }
}
