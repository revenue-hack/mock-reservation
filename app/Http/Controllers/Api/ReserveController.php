<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Services\ReservationService;

class ReserveController extends \App\Http\Controllers\Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ReservationService $rS)
    {
        if (!$rS->saveReservation($request)) {
            \Fetch::reportLog("reservation can't", (array) $request, 'critical');
            return \Response::json(['status' => 404]);
        }
        return \Response::json(['status' => 200]);
    }

    public function index(ReservationService $rS)
    {
        $reservesToJson = $rS->getRemainReserveFrames();
        if (empty($reservesToJson)) {
            \Fetch::reportLog("reserves empty", (array) $reserveToJson, 'critical');
            return \Response::json(['status' => 404]);
        }
        return \Response::json($reservesToJson);
    }

    public function destroy($id, Request $request, ReservationService $rS)
    {
        if (!$rS->deleteReservation($request)) {
            \Fetch::reportLog("reserves can't delete", (array) $request->all(), 'critical');
            return \Response::json(['status' => 404]);
        }
        if (empty($id)) {
            return \Response::json(['status' => 404]);
        }
        return \Response::json(['status' => 200]);
    }
}
