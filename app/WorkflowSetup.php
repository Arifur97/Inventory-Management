<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkflowSetup extends Model
{
    protected $fillable =[

        "form_id", "is_active", "note"
    ];
    public function formname()
    {
    	return $this->belongsTo('App\FormName');
    }
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
