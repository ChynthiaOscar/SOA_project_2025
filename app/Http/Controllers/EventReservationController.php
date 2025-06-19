<?php

namespace App\Http\Controllers;

use App\Utils\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\EventReservation;

class EventReservationController extends Controller
{
    use HttpResponse;

    private $url;

    public function __construct()
    {
        $this->url = env("API_URL");
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $response = Http::get($this->url . '/event_reservations?page=' . $page);
        $res = json_decode($response);
        $data['reservations'] = $res->data->data ?? [];
        $data['pagination'] = $res->data ?? null;
        $data['title'] = "Manage Event Reservations";
        return view('pages.service-event.admin.event_reservations.index', $data);
        return response()->json([
            'data' => $reservations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoriesResponse = Http::get($this->url . "/dish_categories?per_page=1000");
        $categories = json_decode($categoriesResponse);

        $eventSpaceResponse = Http::get($this->url . '/event_spaces?per_page=1000');
        $eventSpaces = json_decode($eventSpaceResponse);

        $event_add_onResponse = Http::get($this->url . '/event_add_ons?per_page=1000');
        $event_add_ons = json_decode($event_add_onResponse);

        $data['title'] = "Create Event Reservation";
        $data['categories'] = $categories->data->data ?? [];
        $data['event_spaces'] = $eventSpaces->data->data ?? [];
        $data['event_add_ons'] = $event_add_ons->data->data ?? [];
        return view('pages.service-event.admin.event_reservations.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $response = Http::post($this->url . '/event_reservations', $request->all());
        $res = json_decode($response);

        if (!$res->success) {
            return $this->error($res->message ?? 'Failed to create event reservation');
        }

        return $this->success('Event reservation created successfully', $res->data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categoriesResponse = Http::get($this->url . "/dish_categories?per_page=1000");
        $categories = json_decode($categoriesResponse);

        $eventSpaceResponse = Http::get($this->url . '/event_spaces?per_page=1000');
        $eventSpaces = json_decode($eventSpaceResponse);

        $addOnsResponse = Http::get($this->url . '/event_add_ons?per_page=1000');
        $eventAddOns = json_decode($addOnsResponse);

        $reservationResponse = Http::get($this->url . '/event_reservations/' . $id);
        $reservation = json_decode($reservationResponse);

        if (!$reservation || !$reservation->success) {

            return redirect()->route('your.reservation.index.route.name')->with('error', 'Reservation not found.');
        }

        $reservationData = $reservation->data ?? null;


        $selectedMenuIds = [];

        if (isset($reservationData->event_menus) && is_array($reservationData->event_menus)) {
            $selectedMenuIds = array_map(function ($menu) {
                return $menu->id;
            }, $reservationData->event_menus);
        }

        $selectedAddOnIds = [];

        if (isset($reservationData->event_add_ons) && is_array($reservationData->event_add_ons)) {
            $selectedAddOnIds = array_map(function ($addon) {
                return $addon->id;
            }, $reservationData->event_add_ons);
        }


        $data['title'] = "Edit Event Reservation";
        $data['categories'] = $categories->data->data ?? [];
        $data['event_spaces'] = $eventSpaces->data->data ?? [];
        $data['event_add_ons'] = $eventAddOns->data->data ?? [];
        $data['event_reservation'] = $reservationData;
        $data['selectedMenuIds'] = $selectedMenuIds;
        $data['selectedAddOnIds'] = $selectedAddOnIds;
        return view('pages.service-event.admin.event_reservations.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $response = Http::put($this->url . '/event_reservations/' . $id, $request->all());
        $res = json_decode($response);

        if (!$res->success) {
            return $this->error($res->message ?? 'Failed to update event reservation');
        }

        return $this->success('Event reservation updated successfully', $res->data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $response = Http::delete($this->url . '/event_reservations/' . $id);
        $res = json_decode($response);
        return redirect()->route('event-reservations.index')->with('success', 'Event reservation deleted successfully');
    }
}
