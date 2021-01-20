<?php


namespace App\Servicies\Draw;


use App\Dto\SlotDto;
use App\Models\Draw;
use App\Models\Lot;
use App\Models\UserWin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class DrawService
{

    /**
     * @return array
     * @throws \Exception
     */
    public function getPrepareActiveDraw()
    {
        $now = new Carbon();
        $result  = [];
        $draw = Draw::whereDate('start_date', '<=',$now)
            ->whereDate('end_date', '>=', $now)
            ->first();

        if ($draw) {
            $result['id'] = $draw->id;
            $result['name'] = $draw->name;
            $result['key'] = (string) Str::uuid();
            $slots =  [];

            $lots = $draw->lots()
                ->where('is_won','=',null)
                ->orWhere('is_won','=', false)
                ->get()->all();
            foreach ($lots as $lot) {
                /* @var $lot Lot */
                $dto = new SlotDto();
                $dto->id    = $lot->id;
                $dto->name  = $lot->name;
                $dto->type  = UserWin::TYPE_LOT;
                $slots[] = $dto;
            }

            $fund = $draw->currency_fund;
            for ($i=0; $i<$draw->currency_slot_count && $fund>0; $i++) {
                $max = $draw->currency_random_to > $draw->currency_fund ? $fund : $draw->currency_random_to;
                $min = $draw->currency_random_from > 0 ? $draw->currency_random_from : 1;

                $count = random_int($min,$max);
                $fund -= $count;

                $dto = new SlotDto();
                $dto->type  = UserWin::TYPE_CURRENCY;
                $dto->count = $count;
                // Сумму делим на 100 потому что наша абстрактная валюта храниться в бд в копейках
                $dto->name  = 'Денежный приз в размере ' . $count/100 . ' Кц!' ;
                $slots[] = $dto;
            }

            if ($draw->currency_random_from > 0 && $draw->currency_random_to > 0) {
                for ($i=0; $i<$draw->score_slot_count;$i++) {
                    $count = random_int($draw->currency_random_from,$draw->currency_random_to);
                    $dto = new SlotDto();
                    $dto->type  = UserWin::TYPE_SCORE;
                    $dto->count = $count;
                    $dto->name  = 'Бонусный приз в размере ' . $count . '!' ;
                    $slots[] = $dto;
                }
            }

            $result['slots'] = $slots;

            Cache::add($result['key'],$result);
        }

        return $result;
    }

    /**
     * @param $key
     * @return mixed|null
     * @throws \Exception
     */
    public function playDraw($key)
    {
        $slot = null;
        $userId = Auth::id();
        $draw = Cache::get($key);
        if($draw) {
            $slotKey = random_int(0,count($draw['slots'])-1);

            if (array_key_exists($slotKey,$draw['slots'])){
                $slot = $draw['slots'][$slotKey];
                $win = new UserWin();
                $win->type = $slot->type;
                $win->name = $slot->name;
                $win->count = $slot->count;
                $win->lot_id = $slot->id;
                $win->user_id = $userId;
                $win->draw_id = $draw['id'];
                $win->status = UserWin::STATUS_WIN;

                if ($win->save()) {
                    Cache::forget($key);
                } else {
                    $slot = null;
                }
            }
        }

        return $slot;
    }
}
