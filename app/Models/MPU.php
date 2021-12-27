<?php

namespace App\Models;

use App\Models\Presale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MPU.
 *
 * @property-read Presale $presale
 *
 * @method static \Database\Factories\MPUFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|MPU newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MPU newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MPU query()
 * @mixin \Eloquent
 */
class MPU extends Model
{
    use HasFactory;

    public function presale()
    {
        return $this->belongsTo(Presale::class);
    }
}
