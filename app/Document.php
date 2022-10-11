<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = "documents";

    protected $fillable =[
        "employee_id", "document_type_id", "document_title", "description", "document_file", "expiry_date", "is_notify", "is_active"
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function document_type()
    {
        return $this->belongsTo('App\DocumentType');
    }


}
