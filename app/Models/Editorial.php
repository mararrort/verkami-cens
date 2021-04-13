<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Editorial extends Model
{
    use HasFactory;

    /**
     * Will use UUID as id.
     */
    public $incrementing = false;
    protected $keyType = 'string';

    public function presales()
    {
        return $this->hasMany(Presale::class);
    }

    public function getPresales($status = null)
    {
        $presales = $this->hasMany(Presale::class);

        if (isset($status)) {
            $presales->where('state', $status);
        }

        return $presales->get();
    }

    public function getTardias()
    {
        return $this->hasMany(Presale::class)->where('late', true)->count();
    }
}
