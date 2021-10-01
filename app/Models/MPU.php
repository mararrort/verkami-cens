<?php

namespace App\Models;

use App\Models\Presale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MPU extends Model
{
    use HasFactory;

    public function presale() {
        return $this->belongsTo(Presale::class);
    }
}
