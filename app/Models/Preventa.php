<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;

class Preventa extends Model
{
    use HasFactory;

    /**
     * Will use UUID as id
     */
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'state' => 'Sin definir',
    ];

    public function empresa() {
        return $this->belongsTo(Empresa::class);
    }
}
