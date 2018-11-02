<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Services\ReservationService;

class HomeReserveController extends \App\Http\Controllers\Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function index(ReservationService $rS)
    {
        $reserves = $rS->getReservesByUser();
        if ($reserves->isEmpty()) {
            \Fetch::reportLog("reserves empty", (array) $reserves, 'info');
            return \Response::json(['status' => 200, 'events' => []]);
        }
        return \Response::json(['status' => 200, 'events' => $reserves]);
    }
}
