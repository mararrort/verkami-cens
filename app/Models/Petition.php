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
    protected $keyType = "string";

    protected $casts = [
        "start" => "date",
        "announced_end" => "date",
        "end" => "date",
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
        return $this->belongsTo(Editorial::class, "editorial_id");
    }

    public function presale()
    {
        return $this->belongsTo(Presale::class, "presale_id");
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
     * Check if the petition makes another presale goes late.
     *
     * It first check if it is an update and then the presale previous state.
     *
     * @return bool
     **/
    public function isNewLate(): bool
    {
        return $this->isUpdate()
            ? (!$this->presale->isLate() && $this->isLate()
                ? true
                : false)
            : false;
    }

    /**
     * Check if the petition makes the company has another presale to finish.
     *
     * Conditions where this returns true:
     * * The petition creates a new presale which is not finished.
     * * The petition updates a presale and old state was "Entregado" and new
     *   it is not
     *
     * @return bool
     **/
    public function isNewNotFinished(): bool
    {
        $return = false;

        if (!$this->isUpdate() && $this->state != "Entregado") {
            $return = true;
        } elseif (
            $this->isUpdate() &&
            $this->presale->isFinished() &&
            $this->state != "Entregado"
        ) {
            $return = true;
        }

        return $return;
    }

    /**
     * Returns if the presale will not be finished.
     *
     * Just checks the state
     *
     * @return bool
     **/
    public function isFinished(): bool
    {
        return $this->state == "Entregado";
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
