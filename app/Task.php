<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable =[
        "date", "title", "company_id", "warehouse_id", "employee_id", "user_id", "document_id", "start_date", "end_date", "note", "document", "status", "is_active"
    ];

    protected $appends = ['docs'];

    public function warehouse()
    {
    	return $this->belongsTo('App\Warehouse');
    }

    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }

    public function company()
    {
    	return $this->belongsTo('App\Company');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function documents() {
        return $this->belongsTo('App\Attachments', 'document');
    }

    public function getDocsAttribute() {
        return $this->documents->documents ?? '';
    }

}
