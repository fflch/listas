<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Unsubscribe extends Mailable
{
    use Queueable, SerializesModels;

    private $to_email;
    private $unsubscribe_link;

    public function __construct($email, $unsubscribe_link)
    {
        $this->to_email = $email;
        $this->unsubscribe_link = $unsubscribe_link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Solicitação de desinscrição em listas de emails');
        $this->to($this->to_email, '');
        $this->from(config('mail.from.address'));
        return $this->markdown('mail.unsubscribe', ['unsubscribe_link' => $this->unsubscribe_link]);
        
    }
}
