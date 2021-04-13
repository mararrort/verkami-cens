<?php

namespace App\Models;

use App\Models\Preventa;
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

    public function preventas()
    {
        return $this->hasMany(Preventa::class);
    }

    public function getPreventas($status = null)
    {
        $preventas = $this->hasMany(Preventa::class);

        if (isset($status)) {
            $preventas->where('state', $status);
        }

        return $preventas->get();
    }

    public function getTardias()
    {
        return $this->hasMany(Preventa::class)->where('tarde', true)->count();
    }
}
