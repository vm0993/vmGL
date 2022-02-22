<?php

namespace App\Mail\Advance;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestSubmitMail extends Mailable
{
    use Queueable, SerializesModels;

    private $details;

    public function __construct($details)
    {
        $this->details = $details;
    }
    
    public function build()
    {
        return $this->markdown('emails.advance.submit-request-mail')
                ->subject($this->details['subject'])
                ->with('details',$this->details);
    }
}
