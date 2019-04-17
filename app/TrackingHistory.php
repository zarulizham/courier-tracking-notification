<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrackingHistory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tracking_code_id',
        'description',
        'event',
        'email_send_at',
        'history_date_time',
    ];

    protected $dates = [
        'email_send_at',
        'history_date_time',
    ];
}
