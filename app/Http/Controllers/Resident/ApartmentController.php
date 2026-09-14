<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $apartment = Apartment::with(['building.residence', 'payments'])->where('user_id', $user->id)->first();

        return view('resident.apartment.show', compact('apartment'));
    }
}
