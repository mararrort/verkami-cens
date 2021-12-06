<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\TODO
 *
 * @method static \Database\Factories\TODOFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TODO newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TODO newQuery()
 * @method static \Illuminate\Database\Query\Builder|TODO onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TODO query()
 * @method static \Illuminate\Database\Query\Builder|TODO withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TODO withoutTrashed()
 * @mixin \Eloquent
 */
class TODO extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Will use UUID as id.
     */
    public $incrementing = false;
    protected $keyType = 'string';
}
