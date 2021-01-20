<?php


namespace App\Servicies\Bank;


use App\Contracts\ProcessingWins;
use App\Jobs\ProcessingWin;
use App\Models\UserWin;

class BankService implements ProcessingWins
{

    /**
     * @param UserWin $userWin
     */
    public function processing(UserWin $userWin)
    {
        // TODO: Добавить обработку отправки в банк, либо постановку в очередь на обработку
        $userWin->status = UserWin::STATUS_CURRENCY_PROCESSING;
        $userWin->save();
        ProcessingWin::dispatch($this,$userWin);
    }

    /**
     * @param UserWin $userWin
     */
    public function done(UserWin $userWin)
    {
        // TODO: Если деньги успешно перевелись то проставляем соответствующий статус, ну и прочие действия...
        $userWin->status = UserWin::STATUS_CURRENCY_PAID_OUT;
        $userWin->save();
    }
}
