<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountCategories extends Model
{
    protected $table = "account_categories";

    protected $fillable =[
        "account_type_id", "name", "code", "is_active",
    ];

    public function account_type()
    {
        return $this->belongsTo('App\AccountTypes');
    }
}
