<?php

namespace App\Models;

use App\Models\Chat;
use App\Models\MessageEntity;
use Illuminate\Database\Eloquent\Model;

/**
 * Message of the Telegram API.
 */
class Message extends Model
{
    private int $message_id;
    private Chat $chat;
    private string $text;
    private array $entities;

    public function __construct($var)
    {
        $this->message_id = $var->message_id;
        $this->chat = new Chat($var->chat);
        if (isset($var->text)) {
            $this->text = $var->text;
        }
        if (isset($var->entities)) {
            foreach ($var->entities as $entity) {
                $this->entities[] = new MessageEntity($entity);
            }
        }
    }

    public function hasText(): bool
    {
        return isset($this->text);
    }

    public function isStartRequest(): bool
    {
        return strpos($this->text, 'start') !== false && ! $this->isStartPetitionsRequest();
    }

    public function isStopRequest(): bool
    {
        return strpos($this->text, 'stop') !== false && ! $this->isStopPetitionsRequest();
    }

    public function isStartPetitionsRequest(): bool
    {
        return strpos($this->text, 'startpetitions') !== false;
    }

    public function isStopPetitionsRequest(): bool
    {
        return strpos($this->text, 'stoppetitions') !== false;
    }

    public function isGetPetitionsRequest(): bool
    {
        return strpos($this->text, 'petition') === false && strpos($this->text, 'stop') !== false;
    }

    public function getChatId(): int
    {
        return $this->chat->getId();
    }

    public function isBotCommand(): bool
    {
        $return = false;

        if (isset($this->entities)) {
            foreach ($this->entities as $entity) {
                if ($entity->isBotCommand()) {
                    $return = true;
                }
            }
        }

        return $return;
    }
}
