<?php

namespace Tests\Unit;

use App\Models\Setting;
use App\Models\User;
use App\Models\UserWin;
use App\Servicies\Bank\BankService;
use App\Servicies\Delivery\DeliveryService;
use App\Servicies\Win\WinService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurrencyConvertTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic unit test.
     *
     * @return void
     */
    public function test_convert()
    {
        $win = UserWin::factory()->create(['type' => UserWin::TYPE_CURRENCY]);
        $service = new WinService(new BankService(),new DeliveryService());
        /* @var $user User */
        $user = $win->user()->get()->first();
        $balance = $user->balance;
        $convertFactor = Setting::whereCode( Setting::CONVERSION_FACTOR)->get()->first();
        if (is_null($convertFactor)) {
            $convertFactor = new Setting();
            $convertFactor->code = Setting::CONVERSION_FACTOR;
            $convertFactor->value = 10;
            $convertFactor->save();
        }
        $service->scorePaid($win);
        $user->refresh();
        $newBalance = $user->balance;
        $this->assertEquals(($balance + $win->count * $convertFactor->value),$newBalance);
    }
}
