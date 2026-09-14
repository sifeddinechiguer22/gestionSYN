<?php

namespace App\Http\Controllers\Syndic;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Building;
use App\Models\User;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Apartment::with(['building', 'resident']);

        if ($request->filled('building')) {
            $query->where('building_id', $request->input('building'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $apartments = $query->paginate(12)->withQueryString();
        $buildings = Building::all();
        $residents = User::where('role', 'resident')->get();

        return view('syndic.apartments.index', compact('apartments', 'buildings', 'residents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'building_id' => ['required', 'exists:buildings,id'],
            'number' => ['required', 'string'],
            'floor' => ['required', 'integer'],
            'monthly_fee' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:occupied,vacant'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        Apartment::create($request->all());

        return back()->with('success', 'Appartement créé avec succès.');
    }
}
