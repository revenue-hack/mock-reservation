<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ReserveFrameController extends Controller
{
    function __construct()
    {
    }

    public function index()
    {
        return view('reservation_frames.index');
    }
}
