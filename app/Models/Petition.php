<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
