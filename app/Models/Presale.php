<?php

namespace App\Models;

use App\Models\Editorial;
use App\Models\MPU;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Presale.
 *
 * @property string name
 * @property string state
 * @property-read \Illuminate\Database\Eloquent\Collection|MPU[] $MPUs
 * @property-read int|null $m_p_us_count
 * @property-read Editorial $editorial
 *
 * @method static \Database\Factories\PresaleFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Presale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Presale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Presale query()
 *
 * @mixin \Eloquent
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
     *
     * @return string
     */
    public function getMarkdown(): string
    {
        return '['.$this->name.']('.$this->url.')';
    }

    public function MPUs()
    {
        return $this->hasMany(MPU::class);
    }
}
