<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * @property-read Uuid id
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

    public function getPresales($status = null)
    {
        $presales = $this->hasMany(Presale::class);

        if (isset($status)) {
            $presales->where('state', $status);
        }

        return $presales->get();
    }

    /**
     * Returns the amount of related late presales.
     */
    public function getLates()
    {
        $presales = $this->hasMany(Presale::class)->get();

        $filtered = $presales->filter(function ($value) {
            return $value->isLate();
        });

        return $filtered->count();
    }

    /**
     * Returns the presales which are not finished.
     *
     * A presale is not finshed wheneer the state is different from 'Entregado'
     * @return Presale[] */
    public function getNotFinishedPresales()
    {
        return $this->hasMany(Presale::class)
            ->where('state', '!=', 'Entregado')
            ->get();
    }

    /**
     * Returns the presales which are not finished and late.
     *
     * A presale is not finshed wheneer the state is different from 'Entregado'.
     * A presale is late when the late attribute is true.
     * @return Presale[] */
    public function getNotFinishedLatePresales()
    {
        $presales = $this->hasMany(Presale::class)
            ->whereNotIn('state', ['Entregado', 'Recaudando'])
            ->get();

        $filtered = $presales->filter(function ($value) {
            return $value->isLate();
        });

        return $filtered;
    }

    /**
     * Returns the text formated as Markdown for Telegram.
     * @return string */
    public function getMarkdown(): string
    {
        return '['.$this->name.']('.$this->url.')';
    }
}
