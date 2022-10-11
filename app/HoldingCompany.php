<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HoldingCompany extends Model
{
    protected $table = "holding_companies";

    protected $fillable =["holding_id", "company_id", "staff_access", "is_active"];

    public function company()
    {
        return $this->belongsTo('App\Company');
    }
}
