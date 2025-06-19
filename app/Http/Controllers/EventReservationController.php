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
        $reservations = EventReservation::with('eventMenus')->paginate(10);
        return response()->json([
            'data' => $reservations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil kategori + menu dari API
        $categoriesResponse = Http::get($this->url . "/dish_categories?per_page=1000");
        $categories = json_decode($categoriesResponse);

        $eventSpaceResponse = Http::get($this->url . '/event_spaces?per_page=1000');
        $eventSpaces = json_decode($eventSpaceResponse);

        $data['title'] = "Create Event Reservation";
        $data['categories'] = $categories->data->data ?? [];
        $data['event_spaces'] = $eventSpaces->data->data ?? [];
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
        $reservation = Http::get($this->url . "/event_reservations/" . $id);
        $data['reservation'] = json_decode($reservation)->data ?? null;
        $data['title'] = "Edit Event Reservation";

        // Get menu categories for editing
        $categoriesResponse = Http::get($this->url . '/dish_categories?with_menus=1');
        $categories = json_decode($categoriesResponse);
        $data['categories'] = [];
        if (isset($categories->data) && is_array($categories->data)) {
            foreach ($categories->data as $category) {
                if (is_object($category) && isset($category->name)) {
                    $data['categories'][] = $category;
                }
            }
        }

        return view('pages.service-event.admin.event_reservations.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payload = [
            'customer_name' => $request->input('user'),
            'event_date' => $request->input('date'),
            'notes' => $request->input('detail'),
            'total_price' => $request->input('total_price'),
            'status' => $request->input('status'),
        ];

        $response = Http::put($this->url . '/event_reservations/' . $id, $payload);
        $res = json_decode($response);

        return redirect()->route('event-reservations.index')->with('success', 'Event reservation updated successfully');
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
