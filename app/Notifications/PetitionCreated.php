<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

use App\Models\Petition;

class PetitionCreated extends Notification
{
    private $petition;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Petition $petition)
    {
        $this->petition = $petition;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    /**
    * @param TelegramUser[] $notifiable
    */
    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()->to($notifiable->id)->view('telegram.create', ['petition' => $this->petition]);
    }
}
