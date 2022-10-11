<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

    protected $fillable =[
        "account_no", "name", "description", "initial_balance", "account_category_id", "default_entry_type", "company_id", "currency_id", "total_balance", "note", "is_default", "is_active"
    ];

    public function account_category()
    {
    	return $this->belongsTo('App\AccountCategories');
    }

    public function company()
    {
    	return $this->belongsTo('App\Company');
    }

    public function currency()
    {
    	return $this->belongsTo('App\Currency');
    }

}
