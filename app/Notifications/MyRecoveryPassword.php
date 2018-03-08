<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class MyRecoveryPassword extends ResetPassword
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token=$token;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //dd($notifiable);
        return (new MailMessage)
            ->subject('Reestablecer tu contraseña')
            ->greeting('Saludos '.$notifiable->name)
            ->line('Estás recibiendo este correo porque hiciste una solicitud de recuperación de contraseña para tu cuenta.')
            ->action('Recuperar contraseña', route('password.reset', [$this->token,'email'=>$notifiable->email]))
            ->line('Si no realizaste esta solicitud, no se requiere realizar ninguna otra acción.')
            ->salutation('Saludos, '. config('app.name'));
    }

}
