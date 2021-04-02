<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Empresa extends Model
{
    use HasFactory;

    /**
     * Will use UUID as id
     */
    public $incrementing = false;
    protected $keyType = 'string';
}
