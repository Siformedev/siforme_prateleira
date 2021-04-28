<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RaffleMail extends Mailable
{
    use Queueable, SerializesModels;
    private $number;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($number)
    {

        $this->number = $number;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('site@agenciapni.com.br')
                    ->subject("Seu numero da Rifa Coletiva Online")
                    ->view('email.raffle_update', ['number' => $this->number]);
    }
}
