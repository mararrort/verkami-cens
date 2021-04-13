<?php

namespace App\Models;

use App\Models\Message;
use Illuminate\Database\Eloquent\Model;

/**
 * Update class of Telegram API.
 */
class Update extends Model
{
    private int $update_id;
    private Message $message;

    public function __construct($var)
    {
        $this->update_id = $var->update_id;
        if (isset($var->message)) {
            $this->message = new Message($var->message);
        }
    }

    public function getId(): int
    {
        return $this->update_id;
    }

    public function isStartRequest(): bool
    {
        return isset($this->message) ? $this->message->isStartRequest() : false;
    }

    public function isStopRequest(): bool
    {
        return isset($this->message) ? $this->message->isStopRequest() : false;
    }

    public function isStartPetitionsRequest(): bool
    {
        return isset($this->message) ? $this->message->isStartPetitionsRequest() : false;
    }

    public function isStopPetitionsRequest(): bool
    {
        return isset($this->message) ? $this->message->isStopPetitionsRequest() : false;
    }

    public function isBotCommand(): bool
    {
        return isset($this->message) ? $this->message->isBotCommand() : false;
    }

    public function getChatId(): int
    {
        return $this->message->getChatId();
    }
}
