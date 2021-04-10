<?php

namespace App\Models;

use App\Models\Chat;
use Illuminate\Database\Eloquent\Model;

/**
 * Message of the Telegram API.
 */
class Message extends Model
{
    private int $message_id;
    private Chat $chat;
    private string $text;

    public function __construct($var)
    {
        $this->message_id = $var->message_id;
        $this->chat = new Chat($var->chat);
        if (isset($var->text)) {
            $this->text = $var->text;
        }
    }

    public function hasText(): bool
    {
        return isset($this->text);
    }

    public function isStartRequest(): bool
    {
        return strpos($this->text, 'start') !== false && strpos($this->text, 'stop') === false;
    }

    public function isStopRequest(): bool
    {
        return strpos($this->text, 'start') === false && strpos($this->text, 'stop') !== false;
    }

    public function getChatId(): int
    {
        return $this->chat->getId();
    }
}
