<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Services\ReservationService;

class ReserveFrameController extends \App\Http\Controllers\Controller
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
        $reserveFrames = $rS->getReserveFrames();
        if (empty($reserveFrames)) {
            \Fetch::reportLog("reserves empty", (array) $reserveFrames, 'critical');
            return \Response::json(['status' => 404]);
        }
        return \Response::json($reserveFrames);
    }

    public function update($id, Request $request, ReservationService $rS)
    {
        if ($rS->updateReserveFrame($request) != 1) {
            \Fetch::catchError("can't update", (array) $request, 'critical');
            return \Response::json(['status' => 404]);
        }
        return \Response::json(['status' => 200]);
    }
}
