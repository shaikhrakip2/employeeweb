<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;    
    public $maildata;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($maildata)
    {
        $this->maildata = $maildata;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {  
        
        $email = $this->markdown('emails.newsletter') 
            ->subject($this->maildata['subject']) 
            ->with('data', $this->maildata); 
       

        return $email;
    }
}
