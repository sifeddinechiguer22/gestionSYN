<?php

namespace App\Http\Controllers\Syndic;

use App\Http\Controllers\Controller;
use App\Models\Residence;
use App\Models\Building;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ResidenceController extends Controller
{
    public function __invoke(Request $request)
    {
        $residence = $request->user()->managedResidence?->load('buildings.apartments');
        $buildingsCount = $residence?->buildings->count() ?? 0;
        $apartmentsCount = $residence?->buildings->flatMap->apartments->count() ?? 0;
        $occupiedCount = $residence?->buildings->flatMap->apartments->where('status', 'occupied')->count() ?? 0;
        $vacantCount = $residence?->buildings->flatMap->apartments->where('status', 'vacant')->count() ?? 0;

        return view('syndic.residence.index', compact(
            'residence',
            'buildingsCount',
            'apartmentsCount',
            'occupiedCount',
            'vacantCount'
        ));
    }
}
