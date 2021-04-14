<?php

namespace App\Models;

use App\Models\Editorial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presale extends Model
{
    use HasFactory;

    /**
     * Will use UUID as id.
     */
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'late' => 'bool',
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

    public function editorial()
    {
        return $this->belongsTo(Editorial::class);
    }

    /**
     * Returns the text formated as Markdown for Telegram.
     * @return string */
    public function getMarkdown(): string
    {
        return '['.$this->name.']('.$this->url.')';
    }

    /**
     * Returns if the presale is not finished.
     *
     * Just checks the state
     *
     * @return bool
     **/
    public function isFinished(): bool
    {
        return $this->state == 'Entregado';
    }
}
