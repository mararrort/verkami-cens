<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudAdicionPreventa extends Model
{
    use HasFactory;

    /**
     * Will use UUID as id
     */
     public $incrementing = false;
     protected $keyType = 'string';
}
