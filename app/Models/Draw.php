<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Draw
 *
 * @property int $id
 * @property string $name
 * @property int|null $currency_fund
 * @property int|null $currency_random_from
 * @property int|null $currency_random_to
 * @property int|null $score_random_from
 * @property int|null $score_random_to
 * @property int|null $currency_slot_count
 * @property int|null $score_slot_count
 * @property string $start_date
 * @property string $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Lot[] $lots
 * @property-read int|null $lots_count
 * @method static \Illuminate\Database\Eloquent\Builder|Draw newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Draw newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Draw query()
 * @method static \Illuminate\Database\Eloquent\Builder|Draw whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Draw whereCurrencyFund($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Draw whereCurrencyRandomFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Draw whereCurrencyRandomTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Draw whereCurrencySlotCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Draw whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Draw whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Draw whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Draw whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Draw whereScoreRandomFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Draw whereScoreRandomTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Draw whereScoreSlotCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Draw whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Draw whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Draw extends Model
{
    use HasFactory,SoftDeletes;

    public function lots()
    {
        return $this->hasMany(Lot::class);
    }

    public function wins()
    {
        return $this->hasMany(UserWin::class);
    }
}
