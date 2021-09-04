<?php

namespace App\Notifications;

use App\Models\Presale;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Twitter\TwitterChannel;
use NotificationChannels\Twitter\TwitterStatusUpdate;
use Carbon\Carbon;

class MPU extends Notification
{
    use Queueable;
    private $presale;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Presale $presale)
    {
        $this->presale = $presale;
        $this->lastUpdate = Carbon::parse($this->presale->updated_at)
            ->locale("es")
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
        return [TelegramChannel::class, TwitterChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param TelegramUser[] $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to($notifiable->id)
            ->view("telegram.MPU", [
                "presale" => $this->presale,
                "lastUpdate" => $this->lastUpdate
            ]);
    }

    /**
     * Send a tweet with the MPU.
     *
     * @param TelegramUser $notifiable Irrelevant
     * @return TwitterStatusUpdate
     **/
    public function toTwitter($notifiable)
    {
        $twitter =
            "La preventa sin finalizar de \"" .
            $this->presale->name .
            "\" lleva sin actualizaciones registradas desde " .
            $this->lastUpdate .
            ". Se tiene registrado que actualmente se encuentra en el estado: \"" .
            $this->presale->state .
            "\". ¿Es correcto?";

        return new TwitterStatusUpdate($tweet);
    }
}
