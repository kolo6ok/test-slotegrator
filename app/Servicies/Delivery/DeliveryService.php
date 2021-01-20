<?php


namespace App\Servicies\Delivery;


use App\Contracts\ProcessingWins;
use App\Jobs\ProcessingWin;
use App\Models\UserWin;

class DeliveryService implements ProcessingWins
{

    /**
     * @param UserWin $userWin
     */
    public function processing(UserWin $userWin)
    {
        // TODO: Действия для отправки выигранного предмета
        $userWin->status = UserWin::STATUS_LOT_DELIVERING;
        $userWin->save();
        ProcessingWin::dispatch($this,$userWin);
    }

    /**
     * @param UserWin $userWin
     */
    public function done(UserWin $userWin)
    {
        // TODO: Вызываем когда доставили выигрыш
        $userWin->status = UserWin::STATUS_LOT_DELIVERED;
        $userWin->save();
    }
}
