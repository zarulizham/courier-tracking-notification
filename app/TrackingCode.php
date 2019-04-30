<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hashids;

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

    protected $appends = [
        'tracking_code_id',
    ];

    public function histories()
    {
        return $this->hasMany('App\TrackingHistory', 'tracking_code_id', 'id')->orderBy('history_date_time', 'DESC');
    }

    public function courier()
    {
        return $this->belongsTo('App\Courier', 'courier_id', 'id');
    }

    public function getTrackingCodeIdAttribute()
    {
        return Hashids::connection(TrackingCode::class)->encode($this->id);
    }

    public function scopeWhereHashId($query, $id)
    {
        $decodedId = Hashids::connection(TrackingCode::class)->decode($id);

        if ($decodedId) {
            return $query->where('id', $decodedId[0]);
        } else {
            return $query;
        }
    }

}
