<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable =[
        "date", "date_checkout", "employee_id", "user_id",
        "checkin", "checkout", "time", "status", "note"
    ];

    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    
}

