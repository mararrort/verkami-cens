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

    private $petition;

    private $editorial;

    private $presale;

    /**
     * Create a new notification instance.
     * @param Petition
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
     */
    public function toTelegram($notifiable)
    {
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
     * Undocumented function long description
     *
     * @param TelegramUser $notifiable Irrelevant
     * @return TwitterStatusUpdate
     **/
    public function toTwitter($notifiable)
    {
        $tweet =
            'Se ha '.
            ($this->petition->isUpdate() ? 'actualizado' : 'añadido').
            ' la información sobre el mecenazgo '.
            ($this->petition->isUpdate()
                ? $this->presale->name
                : $this->petition->presale_name).
            ' de la editorial '.
            ($this->petition->isNewEditorial()
                ? $this->petition->editorial_name
                : $this->editorial->name).
            '. Tienen '.
            (string) ($this->petition->isNewNotFinished()
                ? count($this->editorial->getNotFinishedPresales()) + 1
                : count($this->editorial->getNotFinishedPresales())).
            ' juegos pendientes de entregar, y '.
            (string) (! $this->petition->isFinished() &&
            $this->petition->isNewLate()
                ? count($this->editorial->getNotFinishedLatePresales()) + 1
                : count($this->editorial->getNotFinishedLatePresales())).
            ' pendientes y con retraso.';

        Log::info('This is the tweet that will be send', ['tweet', $tweet]);

        return new TwitterStatusUpdate($tweet);
    }
}
