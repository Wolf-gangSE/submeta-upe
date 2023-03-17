<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecebimentoRecursoNotification extends Notification
{
    use Queueable;

    public $data;
    public $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($usuario, $trabalho, $tipoAvaliador, $tipoAvaliacao)
    {
        if ($tipoAvaliacao == "form") {
            if ($tipoAvaliador == 1) {
                $url = 'avaliador/parecer?evento_id='. $trabalho->evento_id . '&trabalho_id=' . $trabalho->id;
            } else {
                $url = 'avaliador/parecerInterno?evento_id=' . $trabalho->evento_id . '&trabalho_id=' . $trabalho->id;
            }
        } elseif ($tipoAvaliacao == "campos") {
            $url = 'avaliador/parecerBarema?evento_id=' . $trabalho->evento_id . '&trabalho_id=' . $trabalho->id;
        } elseif ($tipoAvaliacao == "link") {
            $url = 'avaliador/parecerLink?evento_id='. $trabalho->evento_id . '&trabalho_id=' . $trabalho->id;
        } else {
            $url = 'avaliador/trabalhos?evento_id=' . $trabalho->evento_id;
        }

        $this->data = date('d/m/Y \à\s  H:i\h', strtotime(now()));
        $this->url = url($url);
        $this->user = $usuario;
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
                    ->line("Prezado/a avaliador/a, a proposta de projeto intitulada {$this->titulo} teve recurso aprovado e está disponível para nova avaliação.")
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
