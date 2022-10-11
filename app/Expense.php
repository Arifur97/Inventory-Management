<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable =[
        "reference_no", "expense_category_id", "warehouse_id", "account_id", 'company_id', "user_id", "cash_register_id", "amount", "document_id", "description"
    ];

    protected $appends = ['docs'];

    public function warehouse()
    {
    	return $this->belongsTo('App\Warehouse');
    }

    public function company()
    {
    	return $this->belongsTo('App\Company');
    }

    public function account()
    {
    	return $this->belongsTo('App\Account');
    }

    public function expenseCategory() {
    	return $this->belongsTo('App\ExpenseCategory');
    }
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function documents() {
        return $this->belongsTo('App\Attachments', 'document_id');
    }

    public function getDocsAttribute() {
        return $this->documents->documents ?? '';
    }
}
