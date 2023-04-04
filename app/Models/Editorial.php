<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * App\Models\Editorial.
 *
 * @property-read Uuid id
 * @property-read Presales[] presales
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Presale[] $presales
 * @property-read int|null $presales_count
 *
 * @method static \Database\Factories\EditorialFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Editorial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Editorial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Editorial query()
 *
 * @mixin \Eloquent
 */
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

    /**
     * Returns the presales which are not finished.
     *
     * A presale is not finshed wheneer the state is different from 'Entregado'
     *
     * @return Collection
     */
    public function getNotFinishedPresales()
    {
        return $this->hasMany(Presale::class)
            ->whereNotIn('state', ['Entregado', 'Abandonado'])
            ->get();
    }

    /**
     * Returns the presales which have finished late.
     *
     * @return Collection
     */
    public function getFinishedLatePresales()
    {
        $presales = $this->hasMany(Presale::class)
            ->whereIn('state', ['Entregado', 'Entregado, faltan recompensas'])
            ->get();

        $filtered = $presales->filter(function ($value) {
            return $value->isLate();
        });

        return $filtered;
    }

    /**
     * Returns the presales which are not finished and late.
     *
     * A presale is not finshed wheneer the state is different from 'Entregado'.
     * A presale is late when the late attribute is true.
     *
     * @return Presale[]
     */
    public function getNotFinishedLatePresales()
    {
        $presales = $this->getNotFinishedPresales();
        $filtered = $presales->filter(function ($value) {
            return $value->isLate();
        });

        return $filtered;
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
}
