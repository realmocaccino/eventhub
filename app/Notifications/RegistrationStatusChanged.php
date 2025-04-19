<?php

namespace App\Notifications;

use App\Enums\RegistrationStatus;
use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationStatusChanged extends Notification
{
    use Queueable;

    protected $event;
    protected $status;

    /**
     * Create a new notification instance.
     */
    public function __construct(Event $event, RegistrationStatus $status)
    {
        $this->event = $event;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Your registration status has changed")
            ->line("Your registration for {$this->event->title} is now {$this->status->value}.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'event_id' => $this->event->id,
            'event_title' => $this->event->title,
            'status' => $this->status->value,
            'message' => match($this->status) {
                RegistrationStatus::Registered => "You're now registered for {$this->event->title}",
                RegistrationStatus::Unregistered => "You've unregistered from {$this->event->title}",
            }
        ];
    }
}
