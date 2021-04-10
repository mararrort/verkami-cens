<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    private int $id;

    public function __construct($var)
    {
        $this->id = $var->id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
