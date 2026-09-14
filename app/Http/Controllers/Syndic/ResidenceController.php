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
        $residence = Residence::with(['buildings.apartments'])->first();
        $buildingsCount = Building::count();
        $apartmentsCount = Apartment::count();
        $occupiedCount = Apartment::where('status', 'occupied')->count();
        $vacantCount = Apartment::where('status', 'vacant')->count();

        return view('syndic.residence.index', compact(
            'residence',
            'buildingsCount',
            'apartmentsCount',
            'occupiedCount',
            'vacantCount'
        ));
    }
}
