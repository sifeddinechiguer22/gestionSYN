<?php

namespace App\Http\Controllers\Syndic;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Residence;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index(Request $request)
    {
        $residence = $request->user()->managedResidence;
        $buildings = $residence
            ? $residence->buildings()->withCount('apartments')->with('residence')->get()
            : collect();

        return view('syndic.buildings.index', compact('buildings', 'residence'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50'],
            'floors_count' => ['required', 'integer', 'min:1'],
        ]);

        $residence = $request->user()->managedResidence;
        abort_unless($residence, 404, 'Aucune résidence n’est associée à ce syndic.');

        Building::create([
            'residence_id' => $residence->id,
            'name' => $request->name,
            'code' => $request->code,
            'floors_count' => $request->floors_count,
            'apartments_count' => 0,
        ]);

        return back()->with('success', 'Bâtiment ajouté avec succès.');
    }
}
