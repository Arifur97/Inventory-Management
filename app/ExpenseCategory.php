<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    protected $fillable =[
        "code", "name", "account_id", "is_active"
    ];

    public function expense() {
    	return $this->hasMany('App\Expense');
    }

    public function account()
    {
        return $this->belongsTo('App\Account');
    }


}
