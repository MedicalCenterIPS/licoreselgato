<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TrakNotification extends Notification
{
    use Queueable;
    public $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $data = $this->data;
        $url = url('/traking_general/' . $data['id_service']);
        if ($data['title'] == 'Nueva Solicitud de Transporte') {
            return (new MailMessage)
                ->subject($data['title'] . ' - Referencia: ' . $data['client'])
                ->view('pages.request_service.notifications.notify_request', ['data' => $data, 'url' => $url])
                ->attach(public_path() . "/storage/servicios/" . str_pad($data['id_service'], 4, "0", STR_PAD_LEFT) . "/Solicitud de transporte " . date('Y') . "-" . str_pad($data['id_service'], 4, "0", STR_PAD_LEFT) . ".pdf");
        } elseif ($data['title'] == 'Solicitud de transporte anulada') {
            return (new MailMessage)
                ->subject($data['title'] . ' - Referencia: ' . $data['client'])
                ->view('pages.request_service.notifications.notify_request', ['data' => $data, 'url' => $url]);
        } elseif ($data['title'] == 'Solicitud de anulación') {
            $url = url('/cancellation_request');
            return (new MailMessage)
                ->subject($data['title'] . ' - Referencia: ' . $data['client'])
                ->view('pages.request_service.notifications.notify_request', ['data' => $data, 'url' => $url]);
        } else {
            return (new MailMessage)
                ->subject($data['title'] . ' - Referencia: ' . $data['client'])
                ->view('pages.request_service.notifications.notify_request', ['data' => $data, 'url' => $url]);
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
