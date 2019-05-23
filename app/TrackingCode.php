<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Mail\TrackingDetails;
use FCM;
use Hashids;
use Mail;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;

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

    public function latestHistory()
    {
        return $this->hasOne('App\TrackingHistory', 'tracking_code_id', 'id')->orderBy('history_date_time', 'DESC');
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

    public function sendPushNotification()
    {
        $title = $this->courier->name.': '.$this->code;
        $body = $this->latestHistory->description.' '.$body = $this->latestHistory->event;
        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
                            ->setSound('default');

        $notification = $notificationBuilder->build();

        $topic = new Topics();
        $topic->topic($this->code);

        $topicResponse = FCM::sendToTopic($topic, null, $notification, null);

        $topicResponse->isSuccess();
        $topicResponse->shouldRetry();
        $topicResponse->error();
    }

    public function sendEmail()
    {
        if ($this->email) {
            if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($this->email)->send(new TrackingDetails($this));
            }
        }
    }

}
