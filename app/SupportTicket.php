<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable =[
        "date", "reference_no", "category_support_id", "company_id", "department_id", "employee_id", "priority", "subject", "user_note", "support_note", "document", "description", "status", "user_id"
    ];

    protected $appends = ['docs'];

    public function documents() {
        return $this->belongsTo('App\Attachments', 'document');
    }

    public function getDocsAttribute() {
        return $this->documents->documents ?? '';
    }

    public function company()
    {
    	return $this->belongsTo('App\Company');
    }

    public function department()
    {
    	return $this->belongsTo('App\Department');
    }

    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }

    public function category_support()
    {
    	return $this->belongsTo('App\CategoriesSupport');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

}
