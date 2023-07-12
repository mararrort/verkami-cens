<?php

namespace App\Notifications;

use App\Models\Presale;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class MPU extends Notification
{
    use Queueable;
    private $presale;
    private $lastUpdate;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Presale $presale)
    {
        $this->presale = $presale;
        $this->lastUpdate = Carbon::parse($this->presale->updated_at)
            ->locale('es')
            ->toFormattedDateString();
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
     * Get the mail representation of the notification.
     *
     * @param  TelegramUser  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to($notifiable->id)
            ->view('telegram.MPU', [
                'presale' => $this->presale,
                'lastUpdate' => $this->lastUpdate,
            ]);
    }
}
