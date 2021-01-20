<?php


namespace App\Contracts;


use App\Models\UserWin;

interface ProcessingWins
{
    public function processing(UserWin $userWin);

    public function done(UserWin $userWin);
}
