<?php

namespace App\Models;

use App\Models\Editorial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 * @property string state
 */
class Presale extends Model
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
     * Checks if the presale is late.
     *
     * It is late if the end date is higher than the announced one, or if it
     * does not have end date and the current date is higher than the announced one.
     *
     * @return bool
     **/
    public function isLate(): bool
    {
        $late = false;

        if (isset($this->announced_end)) {
            if (isset($this->end)) {
                $late = $this->end > $this->announced_end;
            } else {
                $late = now() > $this->announced_end;
            }
        }

        return $late;
    }

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
