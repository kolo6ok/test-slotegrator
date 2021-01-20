<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Servicies\Draw\DrawService;
use Illuminate\Http\Request;

class DrawController extends Controller
{
    /**
     * @var DrawService
     */
    protected DrawService $drawService;

    /**
     * IndexController constructor.
     * @param DrawService $drawService
     */
    public function __construct(DrawService $drawService)
    {
        $this->drawService = $drawService;
    }

    public function prepareDraw()
    {
        $draw = $this->drawService->getPrepareActiveDraw();
        return response()->json($draw);
    }

    public function playDraw(Request $request)
    {
        $key = $request->post('key');
        $slot = $this->drawService->playDraw($key);
        return response()->json($slot);
    }
}
