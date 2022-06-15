<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieResource;
use App\Http\Resources\ReservationResource;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Movie;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function movie(Movie $movie): MovieResource
    {
        // If a seat is present in the reservations list then it's occupied
        return new MovieResource($movie->load('reservations'));
    }

    public function makePayment(Request $request): ReservationResource
    {
        $movie = Movie::query()->findOrFail($request->movie_id);
        $employee = Employee::query()->findOrFail($request->employee_id);

        $client = Client::query()->create([
            'account_name' => $request->account_name,
        ]);

        $payment = Payment::query()->create([
            'status' => $request->status,
            'employee_id' => $employee->id
        ]);

        $reservation = Reservation::query()->create([
            'client_id' => $client->id,
            'movie_id' => $movie->id,
            'payment_id' => $payment->id,
            'day' => $request->day,
            'hour' => $request->hour,
            'seat' => $request->seat,
        ]);

        return new ReservationResource($reservation);
    }
}
