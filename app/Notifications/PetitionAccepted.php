<?php

namespace App\Notifications;

use App\Models\Editorial;
use App\Models\Petition;
use App\Models\Presale;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;


class PetitionAccepted extends Notification
{
    use Queueable;

    /** @var Petition */
    private $petition;

    /** @var Editorial */
    private $editorial;

    /** @var Presale */
    private $presale;

    /**
     * Create a new notification instance.
     *
     * @param Petition
     * @param Editorial
     * @param Presale
     * @return void
     */
    public function __construct(
        Petition $petition,
        Editorial $editorial,
        Presale $presale
    ) {
        $this->petition = $petition;
        $this->editorial = $editorial;
        $this->presale = $presale;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  TelegramUser  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    /**
     * @param  TelegramUser  $notifiable
     * @return TelegramMessage;
     */
    public function toTelegram($notifiable)
    {
        Log::info('A Telegram message will be send', [
            'chat_id' => $notifiable->id,
        ]);

        return TelegramMessage::create()
            ->to($notifiable->id)
            ->view('telegram.accepted', [
                'petition' => $this->petition,
                'editorial' => $this->editorial,
                'presale' => $this->presale,
            ]);
    }
}
