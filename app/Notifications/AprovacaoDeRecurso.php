<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AprovacaoDeRecurso extends Notification
{
    use Queueable;

    public $data;
    public $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($trabalho, $edital)
    {
        $url = "/usuarios/indexAvaliacao/{$edital->id}";

        $this->data = date('d/m/Y \à\s  H:i\h', strtotime(now()));
        $this->url = url($url);
        $this->titulo = $trabalho->titulo;
        $this->trabalho = $trabalho;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {   
        return (new MailMessage())
                    ->subject('Aviso de recurso - Sistema Submeta')
                    ->greeting('Saudações!')
                    ->line("A proposta de projeto intitulada {$this->titulo} foi objeto de recurso e agora está disponível para aprovação ou recusa.")
                    ->action('Acessar', $this->url)
                    ->markdown('vendor.notifications.email');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
        ];
    }
}
