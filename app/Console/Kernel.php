<?php

namespace App\Console;

use App\Models\Presale;
use App\Models\MPU;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Models\TelegramUser;
use Illuminate\Support\Facades\DB;
use App\Notifications\MPU as MPUNotification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
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
                    foreach ($telegramUsers as $telegramUser) {
                        Log::info("A Telegram message will be send to the client " . $telegramUser->id);
                        try {
                            Notification::send(
                                $telegramUser,
                                new MPUNotification($presale)
                            );
                        } catch (CouldNotSendNotification $exception) {
                            Log::warning("Cannot send a Telegram message to the client " . $telegramUser->id . ". It will be removed from the DDBB");
                            $telegramUser->delete();
                        }
                    }

                    $mpu = new MPU();

                    $mpu->presale_id = $presale->id;

                    $mpu->save();
                }
            })
            ->dailyAt("12:00")
            ->environments(["production"]);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . "/Commands");

        require base_path("routes/console.php");
    }

    /**
     * Get the presale to send an MPU about.
     *
     * It will filter the presales where:
     * * They are not finished.
     * * Last update was more than a week ago.
     * * They have not get an MPU or have not an MPU newer than a week ago.
     * * Current date is not early than announced end one.
     */
    public static function getPresale()
    {
        $now = Carbon::now();
        $date = Carbon::now()->subMonth();
        $presale = Presale::where("state", "!=", "Entregado")
            ->whereDate("updated_at", "<=", $date)
            ->whereNotExists(function ($query) use ($date) {
                $query
                    ->select(DB::raw(1))
                    ->from("m_p_u_s")
                    ->whereColumn("m_p_u_s.presale_id", "presales.id")
                    ->whereDate("m_p_u_s.created_at", ">=", $date);
            })
            ->where(function ($query) use ($now) {
                $query
                    ->whereDate("announced_end", "<", $now)
                    ->orWhereNull("announced_end");
            })
            ->inRandomOrder()
            ->first();

        return $presale;
    }
}
