<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrackingCode extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'courier_id',
        'code',
        'email',
        'last_checked_at',
        'completed_at',
    ];

    protected $dates = [
        'completed_at',
    ];

    public function histories()
    {
        return $this->hasMany('App\TrackingHistory', 'tracking_code_id', 'id')->orderBy('history_date_time', 'DESC');
    }

    public function courier()
    {
        return $this->belongsTo('App\Courier', 'courier_id', 'id');
    }
}
