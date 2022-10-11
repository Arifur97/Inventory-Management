<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormName extends Model
{
    public $timestamps = false;
    protected $table = 'form_names';
    protected $fillable = [
        "name", "form_link", "icon", "reference_no_prefix", "reference_no_sequence", "reference_no_latest"
    ];

    public static function workOrderId() {
        return 2;
    }

    public static function supportTicketId() {
        return 8;
    }

}
