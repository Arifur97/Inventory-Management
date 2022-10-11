<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holding extends Model
{
    protected $table = "holdings";

    protected $fillable =["name", "code", "favicon", "vat_number", "email", "holding_logo", "phone_number", "address", "city", "state", "postal_code", "country", "currency_id", "currency_position", "date_format", "invoice_format", "staff_access", "theme", "is_active", "description",];

    public function currency()
    {
    	return $this->belongsTo('App\Currency');
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function unit()
    {
    	return $this->belongsTo('App\Unit');
    }

    public function holdingCompany() {
        return $this->hasMany('App\HoldingCompany')->with('company');
    }

}
