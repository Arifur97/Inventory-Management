<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable =[

        "name", "phone", "email", "code", "address", "company_id", "tax_id", "currency_id", "currency_position", "date_format", "invoice_format", "city", "state", "country", "postal_code", "is_active"
    ];

    public function product()
    {
    	return $this->hasMany('App\Product');
    }

    public function company()
    {
    	return $this->belongsTo('App\Company');
    }

    public function tax()
    {
    	return $this->hasMany('App\Tax');
    }

    public function currency()
    {
    	return $this->hasMany('App\Currency');
    }

}
