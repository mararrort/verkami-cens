<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class pending_update_presales extends Model
{
    use HasUuids;

    protected $table = 'pending_update_presales';

    public function presale(): HasOne
    {
        return $this->hasOne(Presale::class, 'id', 'id');
    }
}
