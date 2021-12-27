<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\TelegramUser.
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser query()
 * @mixin \Eloquent
 */
class TelegramUser extends Model
{
    use Notifiable;

    protected $table = 'telegram_chat';

    protected $fillable = ['id'];

    public function setAcceptedPetitions(bool $var)
    {
        $this->acceptedPetitions = $var;
    }

    public function setCreatedPetitions(bool $var)
    {
        $this->createdPetitions = $var;
    }

    public function isAcceptedPetitions(): bool
    {
        return $this->acceptedPetitions;
    }

    public function isCreatedPetitions(): bool
    {
        return $this->createdPetitions;
    }

    /**
     * Checks if the account is the control group.
     *
     * @return bool
     **/
    public function isControlGroup(): bool
    {
        return $this->id == env('TELEGRAM_CONTROL_GROUP');
    }
}
