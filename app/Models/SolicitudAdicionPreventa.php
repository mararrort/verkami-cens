<?php

namespace App\Models;

use App\Models\Editorial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitudAdicionPreventa extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Will use UUID as id.
     */
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'start' => 'date',
        'announced_end' => 'date',
        'end' => 'date',
    ];

    public function editorial()
    {
        return $this->belongsTo(Editorial::class, 'editorial_id');
    }

    public function preventa()
    {
        return $this->belongsTo(Preventa::class, 'presale_id');
    }
}
