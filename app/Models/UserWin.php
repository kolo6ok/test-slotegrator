<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\UserWin
 *
 * @property int $id
 * @property int $type
 * @property int $status
 * @property int $user_id
 * @property int $draw_id
 * @property int|null $lot_id
 * @property int $count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Lot|null $lot
 * @property-read \App\Models\Draw|null $draw
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserWin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserWin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserWin query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserWin whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserWin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserWin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserWin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserWin whereLotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserWin whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserWin whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserWin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserWin whereUserId($value)
 * @mixin \Eloquent
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|UserWin whereName($value)
 */
class UserWin extends Model
{
    use HasFactory,SoftDeletes;

    const TYPE_LOT = 1;
    const TYPE_SCORE = 2;
    const TYPE_CURRENCY = 3;

    const STATUS_LOT_DELIVERING = 101;
    const STATUS_LOT_DELIVERED = 102;

    const STATUS_SCORE_PROCESSING = 201;
    const STATUS_SCORE_PAID_OUT = 202;

    const STATUS_CURRENCY_PROCESSING = 301;
    const STATUS_CURRENCY_PAID_OUT = 302;
    const STATUS_CURRENCY_TO_SCORE = 303;

    const STATUS_WIN = 10;
    const STATUS_REJECT = 11;

    private static $statusNames = [
        self::STATUS_WIN => 'Выигрыш',
        self::STATUS_REJECT => 'Отклонен',
        self::STATUS_LOT_DELIVERING => 'Доставляется',
        self::STATUS_LOT_DELIVERED => 'Получен',
        self::STATUS_SCORE_PROCESSING => 'Обрабатывается',
        self::STATUS_SCORE_PAID_OUT => 'Зачислен на баланс',
        self::STATUS_CURRENCY_PROCESSING => 'Обрабатывается',
        self::STATUS_CURRENCY_PAID_OUT => 'Выплачен',
        self::STATUS_CURRENCY_TO_SCORE => 'Зачислен на баланс',
    ];

    protected $table = 'users_wins';

    protected static function booted()
    {
        static::created(function ($win) {
            static::updateWinFund($win);
        });

        static::updated(function ($win) {
            static::updateWinFund($win);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }

    public function draw()
    {
        return $this->belongsTo(Draw::class);
    }

    public function statusName()
    {
        return self::getStatusName($this->status);
    }

    public static function getStatusName($status)
    {
        return self::$statusNames[$status];
    }

    private static function updateWinFund(UserWin $win)
    {
        if (in_array($win->status,[UserWin::STATUS_WIN, UserWin::STATUS_REJECT])) {

            if ($win->type === UserWin::TYPE_LOT) {

                $lot = $win->lot;
                if ($lot) {
                    $lot->is_won = $win->status !== UserWin::STATUS_REJECT;
                    $lot->save();
                }

            } elseif ($win->type === UserWin::TYPE_CURRENCY) {

                $draw = $win->draw;
                if ($draw) {
                    $draw->currency_fund += $win->status !== UserWin::STATUS_REJECT ? $win->count * -1 : $win->count ;
                    $draw->save();
                }

            }

        }
    }
}
