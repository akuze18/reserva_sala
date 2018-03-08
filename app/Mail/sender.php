<?php
/**
 * Created by PhpStorm.
 * User: Ariel
 * Date: 09/10/2017
 * Time: 20:19
 */

namespace App\Mail;


use App\Solicitud;
use App\User;
use Illuminate\Support\Facades\Mail;

class sender
{
    /**
     * @var User
     */
    private $destinatario;

    public function __construct(User $destinatario)
    {
        $this->destinatario = $destinatario;
    }
    public function solicitud_cambio(Solicitud $solicitud)
    {
        Mail::to($this->destinatario)
            ->send(new solicitud_cambio_estado($solicitud));
    }
}