<?php

namespace App\Models;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preventa extends Model
{
    use HasFactory;

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

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'state' => 'Sin definir',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
