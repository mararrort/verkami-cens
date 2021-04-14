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
        return [TelegramChannel::class, TwitterChannel::class];
    }

    /**
     * @param TelegramUser[] $notifiable
     */
    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()->to($notifiable->id)->view('telegram.accepted', ['petition' => $this->petition, 'editorial' => $this->editorial, 'presale' => $this->presale]);
    }

    /**
     * Send a tweet with the petition information.
     *
     * Undocumented function long description
     *
     * @param $notifiable Irrelevant
     * @return TwitterStatusUpdate
     **/
    public function toTwitter($notifiable)
    {
        // Ensures the tweet is send only once
        if ($notifiable->isControlGroup()) {
            $tweet = '';
            if ($this->petition->isUpdate()) {
                $tweet = 'Se ha actualizado la información sobre el mecenazgo '
                    .$this->presale->name.' de la editorial '.$this->editorial->name
                    .'.';
            } else {
                $tweet = 'Se ha añadido la información sobre el mecenazgo '
                .$this->petition->presale_name.' de la editorial '.$this->petition->editorial_name
                .'.';
            }

            $tweet = $tweet.' Tienen '.(string) ($this->petition->isNewNotFinished() ? count($editorial->getNotFinishedPresales()) + 1 : count($this->editorial->getNotFinishedPresales()))
                .' juegos pendientes de entregar, y '.(string) (($this->petition->isNewNotFinished() && $this->petition->isNewLate()) ? count($this->editorial->getNotFinishedLatePresales()) + 1 : count($this->editorial->getNotFinishedLatePresales()))
                .' pendientes y con retraso.';

            Log::info('This is the tweet that will be send', ['tweet', $tweet]);

            return new TwitterStatusUpdate($tweet);
        }
    }
}
