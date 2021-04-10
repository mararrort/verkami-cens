<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Chat;

/**
 * Message of the Telegram API
 */
class Message extends Model
{
    private int $message_id;
    private Chat $chat;
    private string $text;

    public function __construct($var) {
        $this->message_id = $var->message_id;
        $this->chat = new Chat($var->chat);
        if (isset($var->text)) {
            $this->text = $var->text;
        }
    }

    public function hasText() :bool {
        return isset($this->text);
    }

    public function isStartRequest() : bool
    {
        return $this->text == "/start";
    }

    public function isStopRequest() : bool
    {
        return $this->text == "/stop";
    }

    public function getChatId() : int
    {
        return $this->chat->getId();
    }
}
