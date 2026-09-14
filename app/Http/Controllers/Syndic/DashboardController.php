<?php

namespace App\Http\Controllers\Syndic;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Complaint;
use App\Models\Apartment;
use App\Models\Announcement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        // 1. Calculate stats from Eloquent DB
        $totalCollectedThisMonth = Payment::where('status', 'paid')
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');

        $totalUnpaid = Payment::whereIn('status', ['pending', 'late'])->sum('amount');
        
        $activeComplaintsCount = Complaint::whereIn('status', ['déposée', 'en_attente', 'open', 'in_progress'])->count();
        $urgentComplaintsCount = Complaint::where('priority', 'urgent')->whereIn('status', ['déposée', 'en_attente', 'open', 'in_progress'])->count();

        $occupiedApartmentsCount = Apartment::where('status', 'occupied')->count();
        $totalApartmentsCount = Apartment::count();

        // 2. Fetch recent tables & widgets
        $recentPayments = Payment::with(['apartment.building', 'payer'])
            ->latest('payment_date')
            ->take(5)
            ->get();

        $recentComplaints = Complaint::with(['apartment', 'resident'])
            ->whereIn('status', ['déposée', 'en_attente', 'open', 'in_progress'])
            ->latest()
            ->take(3)
            ->get();

        $latestAnnouncement = Announcement::with('author')
            ->orderBy('pinned', 'desc')
            ->latest('published_at')
            ->first();

        return view('syndic.dashboard', compact(
            'totalCollectedThisMonth',
            'totalUnpaid',
            'activeComplaintsCount',
            'urgentComplaintsCount',
            'occupiedApartmentsCount',
            'totalApartmentsCount',
            'recentPayments',
            'recentComplaints',
            'latestAnnouncement'
        ));
    }

    public function downloadReport(Request $request)
    {
        $user = $request->user();
        $residence = $user->managedResidence ?? \App\Models\Residence::first();

        $totalCollectedThisMonth = Payment::where('status', 'paid')
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');

        $totalUnpaid = Payment::whereIn('status', ['pending', 'late'])->sum('amount');
        $activeComplaintsCount = Complaint::whereIn('status', ['déposée', 'en_attente', 'open', 'in_progress'])->count();
        $occupiedApartmentsCount = Apartment::where('status', 'occupied')->count();
        $totalApartmentsCount = Apartment::count();

        $recentPayments = Payment::with(['apartment.building', 'payer'])
            ->latest('payment_date')
            ->take(10)
            ->get();

        $recentComplaints = Complaint::with(['apartment', 'resident'])
            ->whereIn('status', ['déposée', 'en_attente', 'open', 'in_progress'])
            ->latest()
            ->take(5)
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.dashboard_report', compact(
            'residence',
            'totalCollectedThisMonth',
            'totalUnpaid',
            'activeComplaintsCount',
            'occupiedApartmentsCount',
            'totalApartmentsCount',
            'recentPayments',
            'recentComplaints'
        ));

        return $pdf->download('Rapport_Gestion_Syndic_' . date('Y_m_d') . '.pdf');
    }
}
