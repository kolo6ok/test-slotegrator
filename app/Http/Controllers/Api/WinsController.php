<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\UserWinRequest;
use App\Http\Resources\UserWinResource;
use App\Models\UserWin;
use App\Servicies\Win\WinService;
use Illuminate\Http\Request;

class WinsController extends Controller
{
    /**
     * @var WinService
     */
    private WinService $winService;

    /**
     * WinsController constructor.
     * @param WinService $winService
     */
    public function __construct(WinService $winService)
    {
        $this->winService = $winService;
    }

    public function getWins()
    {
        $wins = $this->winService->getUserWins();
        return UserWinResource::collection($wins);
    }

    public function currencyToScore(UserWinRequest $request)
    {
        $id = $request->post('id');
        $win = $this->findModel($id);
        $win = $this->winService->currencyToScore($win);
        return new UserWinResource($win);
    }

    public function takeWin(UserWinRequest $request)
    {
        $id = $request->post('id');
        $win = $this->findModel($id);
        $win = $this->winService->takeWin($win);
        return new UserWinResource($win);
    }

    public function rejectWin(UserWinRequest $request)
    {
        $id = $request->post('id');
        $win = $this->findModel($id);
        $win = $this->winService->rejectWin($win);
        return new UserWinResource($win);
    }

    private function findModel($id)
    {
        $win = UserWin::find($id);
        abort_if(is_null($win),404);
        return $win;
    }
}
