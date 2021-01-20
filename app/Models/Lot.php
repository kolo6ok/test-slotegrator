<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Lot
 *
 * @property int $id
 * @property string $name
 * @property int $draw_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Draw $draw
 * @method static \Illuminate\Database\Eloquent\Builder|Lot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lot query()
 * @method static \Illuminate\Database\Eloquent\Builder|Lot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lot whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lot whereDrawId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lot whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lot whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Lot extends Model
{
    use HasFactory,SoftDeletes;

    public function draw()
    {
        return $this->belongsTo(Draw::class);
    }
}
