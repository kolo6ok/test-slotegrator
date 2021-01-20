<?php


namespace App\Servicies\Win;


use App\Models\Setting;
use App\Models\UserWin;
use App\Servicies\Bank\BankService;
use App\Servicies\Delivery\DeliveryService;
use Illuminate\Support\Facades\Auth;

class WinService
{
    /**
     * @var BankService
     */
    protected BankService $bankService;

    /**
     * @var DeliveryService
     */
    protected DeliveryService $deliveryService;


    /**
     * WinService constructor.
     * @param BankService $bankService
     * @param DeliveryService $deliveryService
     */
    public function __construct(BankService $bankService, DeliveryService $deliveryService)
    {
        $this->bankService = $bankService;
        $this->deliveryService = $deliveryService;
    }

    /**
     * @param UserWin $win
     * @return UserWin|UserWin[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function takeWin(UserWin $win)
    {
        switch ($win->type) {
            case UserWin::TYPE_LOT:
                $this->deliveryService->processing($win);
                break;
            case UserWin::TYPE_CURRENCY:
                $this->bankService->processing($win);
                break;
            default:
                $this->scorePaid($win);
                break;
        }

        $win->refresh();
        return $win;
    }

    /**
     * @param UserWin $win
     * @return null
     */
    public function rejectWin(UserWin $win)
    {
        $win->status = UserWin::STATUS_REJECT;
        $win->save();
        return $win;
    }

    /**
     * @param UserWin $win
     * @return UserWin|UserWin[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function currencyToScore(UserWin $win)
    {
        $this->scorePaid($win);
        $win->refresh();
        return $win;
    }

    /**
     * @param UserWin $win
     */
    public function scorePaid(UserWin $win)
    {
        $user = $win->user;
        $conversionFactor = Setting::getByCode(Setting::CONVERSION_FACTOR);
        $user->balance += $win->type == UserWin::TYPE_CURRENCY ? $win->count * $conversionFactor : $win->count;

        if ($user->save()) {
            $win->status = $win->type == UserWin::TYPE_CURRENCY ? UserWin::STATUS_CURRENCY_TO_SCORE : UserWin::STATUS_SCORE_PAID_OUT;
            $win->save();
        }

    }

    /**
     * @param null $userId
     * @return array
     */
    public function getUserWins($userId = null)
    {
        $userId = $userId || Auth::id();
        return UserWin::where('user_id','=',$userId)
            ->orderBy('created_at','desc')
            ->get()->all();
    }

}
