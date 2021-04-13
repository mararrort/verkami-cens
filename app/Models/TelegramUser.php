<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TelegramUser extends Model
{
    use Notifiable;

    protected $table = 'telegram_chat';

    protected $fillable = ['id'];

    public function setAcceptedPetitions(Bool $var)
    {
        $this->acceptedPetitions = $var;
    }

    public function setCreatedPetitions(Bool $var)
    {
        $this->createdPetitions = $var;
    }

    public function isAcceptedPetitions() : bool
    {
        return $this->acceptedPetitions;
    }

    public function isCreatedPetitions() : bool
    {
        return $this->createdPetitions;
    }
}
