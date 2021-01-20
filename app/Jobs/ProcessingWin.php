<?php

namespace App\Jobs;

use App\Contracts\ProcessingWins;
use App\Models\UserWin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessingWin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var ProcessingWins
     */
    private ProcessingWins $service;
    /**
     * @var UserWin
     */
    private UserWin $win;

    /**
     * Create a new job instance.
     *
     * @param ProcessingWins $service
     * @param UserWin $userWin
     */
    public function __construct(ProcessingWins $service,UserWin $userWin)
    {
        $this->service = $service;
        $this->win = $userWin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->service->done($this->win);
    }
}
