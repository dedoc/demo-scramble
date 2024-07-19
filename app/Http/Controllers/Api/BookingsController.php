<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Place;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    /**
     * List bookings.
     *
     * List all bookings of the user.
     */
    public function index(Request $request)
    {
        return BookingResource::collection($request->user()->bookings);
    }

    /**
     * Create booking.
     *
     * Create a booking for the given place at the given date.
     */
    public function store(Request $request)
    {
        $request->validate([
            'place_id' => ['required', 'exists:places,id'],
            'date' => ['required', 'date'],
        ]);

        $place = Place::find($request->get('place_id'));
        if (! $place->available($request->date('date'))) {
            return response()->json(['message' => 'Place is not available at the given date'], 409);
        }

        $booking = $request->user()->bookings()->create([
            'place_id' => $request->get('place_id'),
            'date' => $request->get('date'),
        ]);

        /**
         * The created booking.
         *
         * @status 201
         */
        return BookingResource::make($booking);
    }

    /**
     * Update booking.
     *
     * Update the date of the given booking.
     */
    public function update(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'date' => ['required', 'date'],
        ]);

        if (! $booking->place->available($request->date('date'))) {
            return response()->json(['message' => 'Place is not available at the given date'], 409);
        }

        $booking->update($data);

        return BookingResource::make($booking);
    }

    /**
     * Show booking.
     *
     * Show the given booking.
     */
    public function show(Booking $booking)
    {
        return BookingResource::make($booking);
    }

    /**
     * Delete booking.
     *
     * Delete the given booking.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return response()->noContent();
    }
}
