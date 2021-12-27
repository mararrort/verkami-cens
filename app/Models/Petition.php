<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Petition.
 *
 * @property-read Presale $presale;
 * @property-read \App\Models\Editorial $editorial
 * @property-read \App\Models\Presale $presale
 *
 * @method static \Database\Factories\PetitionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Petition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Petition newQuery()
 * @method static \Illuminate\Database\Query\Builder|Petition onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Petition query()
 * @method static \Illuminate\Database\Query\Builder|Petition withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Petition withoutTrashed()
 * @mixin \Eloquent
 */
class Petition extends Model
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

    /**
     * Checks if the presale would be late.
     *
     * It would be late if the end date is higher than the announced one, or if it
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
        return $this->belongsTo(Editorial::class, 'editorial_id');
    }

    public function presale()
    {
        return $this->belongsTo(Presale::class, 'presale_id');
    }

    /**
     * Check if the petition is an update.
     *
     * The check is based in the existene of a relation with an existent presale
     *
     * @return bool
     */
    public function isUpdate(): bool
    {
        return isset($this->presale_id);
    }

    /**
     * Returns if the petition creates a new editorial.
     *
     * @return bool
     **/
    public function isNewEditorial(): bool
    {
        return is_null($this->editorial_id);
    }
}
