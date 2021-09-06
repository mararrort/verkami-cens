<?php

namespace App\Notifications;

use App\Models\Editorial;
use App\Models\Petition;
use App\Models\Presale;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Twitter\TwitterChannel;
use NotificationChannels\Twitter\TwitterStatusUpdate;

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
     * @param  TelegramUser $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($notifiable->isControlGroup()) {
            return [TelegramChannel::class, TwitterChannel::class];
        } else {
            return [TelegramChannel::class];
        }
    }

    /**
     * @param TelegramUser $notifiable
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

    /**
     * Send a tweet with the petition information.
     *
     * @param TelegramUser $notifiable Irrelevant
     * @return TwitterStatusUpdate
     **/
    public function toTwitter($notifiable)
    {
        $tweet =
            'Se ha actualizado información respecto a la editorial '.
            $this->editorial->name.
            '. Juegos pendientes de entregar: '.
            (string)count($this->editorial->getNotFinishedPresales());

        $unfinishedLatePresales = (string)count($this->editorial->getNotFinishedLatePresales());

        if ($unfinishedLatePresales) {
            $tweet =
                $tweet.
                ' (De los cuales '.
                $unfinishedLatePresales.
                ' con retraso)';
        }

        Log::info('A tweet will be send', ['tweet' => $tweet]);

        return new TwitterStatusUpdate($tweet);
    }
}
