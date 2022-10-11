<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkflowSetupStage extends Model
{
    protected $table = 'workflow_setup_stages';
    protected $fillable =[
        
        "workflow_setup_id", "stage", "designation_id", "user_id"
    ];
}
