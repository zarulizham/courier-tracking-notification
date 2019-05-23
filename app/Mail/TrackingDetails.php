<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\TrackingCode;

class TrackingDetails extends Mailable
{
    use Queueable, SerializesModels;
    public $tracking_code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(TrackingCode $tracking_code)
    {
        $this->tracking_code = $tracking_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->tracking_code->courier_id == 1 || $this->tracking_code->courier_id == 3) {
            return $this->markdown('emails.tracking.details.poslaju');
        } else if ($this->tracking_code->courier_id == 4) {
            return $this->markdown('emails.tracking.details.ninjavan');
        } else if ($this->tracking_code->courier_id == 5) {
            return $this->markdown('emails.tracking.details.jnt');
        }
    }
}
