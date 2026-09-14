<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComplaintRequest;
use App\Models\Complaint;
use App\Models\Apartment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $complaints = Complaint::with(['replies', 'apartment.building.residence'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $apartment = Apartment::with('building.residence.syndic')->where('user_id', $user->id)->first();

        return view('resident.complaints.index', compact('complaints', 'apartment'));
    }

    public function store(StoreComplaintRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();
        $apartment = Apartment::with('building.residence')->where('user_id', $user->id)->first();

        $data['user_id'] = $user->id;
        $data['apartment_id'] = $apartment?->id ?? 1;
        $data['title'] = !empty($data['title']) ? $data['title'] : 'Signalement du ' . date('d/m/Y à H:i');
        $data['category'] = $data['category'] ?? 'other';
        $data['priority'] = $data['priority'] ?? 'medium';
        $data['ticket_number'] = 'TK-' . date('Y') . '-' . str_pad((string)(Complaint::count() + 1), 3, '0', STR_PAD_LEFT);
        $data['status'] = 'déposée';

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('complaints', 'public');
        }

        $complaint = Complaint::create($data);
        $complaint->load(['apartment.building.residence', 'resident']);

        // Generate PDF Document automatically
        $pdfFileName = 'complaints_pdf/' . $complaint->ticket_number . '.pdf';
        $pdf = Pdf::loadView('pdf.complaint', compact('complaint'));
        Storage::disk('public')->put($pdfFileName, $pdf->output());

        $complaint->update(['pdf_path' => $pdfFileName]);

        return back()->with('success', 'Votre réclamation a bien été déposée, enregistrée et transmise au Syndic. Votre récépissé PDF est disponible !');
    }

    public function downloadPdf(Request $request, Complaint $complaint)
    {
        // Ensure the resident owns the complaint
        if ($complaint->user_id !== $request->user()->id) {
            abort(403);
        }

        $complaint->load(['apartment.building.residence', 'resident']);

        if (!$complaint->pdf_path || !Storage::disk('public')->exists($complaint->pdf_path)) {
            $pdfFileName = 'complaints_pdf/' . $complaint->ticket_number . '.pdf';
            $pdf = Pdf::loadView('pdf.complaint', compact('complaint'));
            Storage::disk('public')->put($pdfFileName, $pdf->output());
            $complaint->update(['pdf_path' => $pdfFileName]);
        }

        return response()->download(storage_path('app/public/' . $complaint->pdf_path), 'Reclamation_' . $complaint->ticket_number . '.pdf');
    }
}
