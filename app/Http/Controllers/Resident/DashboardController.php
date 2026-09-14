<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Payment;
use App\Models\Complaint;
use App\Models\Announcement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        // 1. Fetch user's apartment & residence & syndic
        $apartment = Apartment::with(['building.residence.syndic'])->where('user_id', $user->id)->first();
        $residence = $apartment?->building?->residence;
        $syndic = $residence?->syndic ?? \App\Models\User::where('role', 'syndic')->first();

        // 2. Fetch latest payment & history
        $myPayments = Payment::where('user_id', $user->id)
            ->when($apartment, fn($q) => $q->orWhere('apartment_id', $apartment->id))
            ->latest('payment_date')
            ->take(5)
            ->get();

        $latestPayment = $myPayments->first();
        $isUpToDate = $latestPayment && $latestPayment->status === 'paid';

        // 3. Fetch resident's complaints
        $myComplaints = Complaint::with('replies')
            ->where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();

        // 4. Announcements
        $announcements = Announcement::latest('published_at')->take(3)->get();

        return view('resident.dashboard', compact(
            'apartment',
            'residence',
            'syndic',
            'myPayments',
            'latestPayment',
            'isUpToDate',
            'myComplaints',
            'announcements'
        ));
    }
}
