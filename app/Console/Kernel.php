<?php

namespace App\Console;

use App\Models\MPU;
use App\Models\pending_update_presales;
use App\Models\Presale;
use App\Models\TelegramUser;
use App\Notifications\MPU as MPUNotification;
use Exception;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use NotificationChannels\Telegram\Exceptions\CouldNotSendNotification;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule
            ->call(function () {
                $telegramUsers = TelegramUser::all();
                $presale = $this->getPresale();

                if ($presale) {
                    $mpu = new MPU();
                    $mpu->presale_id = $presale->id;
                    $mpu->save();

                    foreach ($telegramUsers as $telegramUser) {
                        Log::info('A Telegram message will be send to the client '.$telegramUser->id);
                        try {
                            Notification::send(
                                $telegramUser,
                                new MPUNotification($presale)
                            );
                        } catch (CouldNotSendNotification $exception) {
                            Log::warning('Cannot send a Telegram message to the client '.$telegramUser->id.'. It will be removed from the DDBB');
                            $telegramUser->delete();
                        } catch (Exception $exception) {
                            Log::warning('There has been an exception');
                        }
                    }
                }
            })
            ->dailyAt('12:00')
            ->weekdays()
            ->environments(['production']);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    public static function getPresale() : ?Presale
    {
        $pup = pending_update_presales::all();
        if ($pup) {
            return $pup[0]->presale;
        }
    }
}
