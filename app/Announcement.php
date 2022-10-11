<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable =[
        "title", "start_date", "end_date", "summary", "description", "company_id ", "department_id", "added_by", "is_notify", "document", "user_id", "warehouse_id"
    ];

    public function warehouse()
    {
    	return $this->belongsTo('App\Warehouse');
    }
}
