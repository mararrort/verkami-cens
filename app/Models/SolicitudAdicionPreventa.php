<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitudAdicionPreventa extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Will use UUID as id
     */
     public $incrementing = false;
     protected $keyType = 'string';
     
     public function empresa()
     {
        return $this->belongsTo(Empresa::class, 'editorial_id');
     }
}
