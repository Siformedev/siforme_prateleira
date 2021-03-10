<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChamadoRespondido extends Mailable
{
    use Queueable, SerializesModels;
    public $called;
    public $msg;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($called, $msg)
    {
        //
        $this->called = $called;
        $this->msg = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("Seu chamado foi respondido")
            ->markdown('email.markdown.called_update');
    }
}
