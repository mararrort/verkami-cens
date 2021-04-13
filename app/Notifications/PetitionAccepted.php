<?php

namespace App\Notifications;

use App\Models\Editorial;
use App\Models\Petition;
use App\Models\Presale;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class PetitionAccepted extends Notification
{
    use Queueable;

    private $petition;

    private $editorial;

    private $presale;

    /**
     * Create a new notification instance.
     * @param Petition
     * @return void
     */
    public function __construct(Petition $petition, Editorial $editorial, Presale $presale)
    {
        $this->petition = $petition;
        $this->editorial = $editorial;
        $this->presale = $presale;
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
        return TelegramMessage::create()->to($notifiable->id)->view('telegram.accepted', ['petition' => $this->petition, 'editorial' => $this->editorial, 'presale' => $this->presale]);
    }
}
