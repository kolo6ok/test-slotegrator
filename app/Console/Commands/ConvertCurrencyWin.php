<?php

namespace App\Console\Commands;

use App\Models\UserWin;
use App\Servicies\Win\WinService;
use Illuminate\Console\Command;

class ConvertCurrencyWin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wins:currency-convert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Преобразовывает денежный приз в баллы';

    /**
     * @var WinService
     */
    private WinService $winService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(WinService $winService)
    {
        parent::__construct();
        $this->winService = $winService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $wins = UserWin::where('type','=',UserWin::TYPE_CURRENCY)
            ->where('status','=', UserWin::STATUS_WIN)
            ->orderBy('created_at')
            ->limit(200)
            ->get()->all();

        foreach ($wins as $win) {
            $this->winService->scorePaid($win);
        }

        return 0;
    }
}
