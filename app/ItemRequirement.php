<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemRequirement extends Model
{
    protected $fillable =[

        "reference_no", "trans_date", "user_id", "warehouse_id", "company_id", "item", "form_status_id", "stage", "document", "note", "workflow_status_id", "approval_status_id"
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
