<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageEntity extends Model
{
    private $type;
    
    public function __construct($var) {
        $this->type = $var->type;
    }

    public function isBotCommand() : bool
    {
        return $this->type == "bot_command";
    }
}
