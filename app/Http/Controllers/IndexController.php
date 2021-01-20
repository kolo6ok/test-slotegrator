<?php

namespace App\Http\Controllers;

use App\Servicies\Draw\DrawService;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class IndexController extends Controller
{

    public function index()
    {
        return Inertia::render('Index', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    public function wins()
    {
        return Inertia::render('Wins', [
           'userBalance' => (int)\Auth::user()->balance ?? 0
        ]);
    }
}
