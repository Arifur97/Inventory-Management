<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = "companies";
    protected $fillable =["name", "code", "favicon", "vat_number", "email","company_logo", "phone_number", "address", "city", "state", "postal_code", "country", "currency_id", "currency_position", "date_format", "invoice_format", "staff_access", "theme", "is_active", "description"];

    public function currency()
    {
    	return $this->belongsTo('App\Currency');
    }


}
