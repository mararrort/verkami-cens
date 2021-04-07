<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TODO extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Will use UUID as id
     */
    public $incrementing = false;
    protected $keyType = 'string';
}
