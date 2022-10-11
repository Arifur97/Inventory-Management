<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGeneralSetting extends Model
{
    protected $table = "user_general_setting";

    protected $fillable = [
        "id",
        "user_id",
        "role_id",
        "company_id",
        "warehouse_id"
    ];


    public function company() {
        return $this->belongsTo('App\Company', 'company_id');
    }

    
}
