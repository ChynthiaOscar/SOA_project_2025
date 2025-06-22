<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function create()
    {
        return view('pages.service-event.reservations.create');
    }
    public function validateReservation()
    {
        return view('pages.service-event.reservations.validate');
    }
}
