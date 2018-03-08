<?php

namespace App\Mail;

use App\Solicitud;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class solicitud_cambio_estado extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * @var Solicitud
     */
    public $solicitud;

    public function __construct(Solicitud $solicitud)
    {
        //
        $this->solicitud = $solicitud;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.solicitud_cambio_estado')
            ->from('admin@localhost','Sistema')
            ->subject('Cambio de Estado de Solicitud');
    }
}
