<?php

namespace App\Http\Controllers\Syndic;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintReply;
use App\Models\Residence;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $residence = $user->managedResidence ?? Residence::first();

        $query = Complaint::with(['resident', 'apartment.building'])
            ->whereHas('apartment.building', function ($q) use ($residence) {
                if ($residence) {
                    $q->where('residence_id', $residence->id);
                }
            })
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('resident', fn($r) => $r->where('name', 'like', "%{$search}%"));
            });
        }

        $complaints = $query->paginate(12)->withQueryString();

        $counts = [
            'total' => Complaint::count(),
            'déposée' => Complaint::where('status', 'déposée')->count(),
            'en_attente' => Complaint::where('status', 'en_attente')->count(),
            'avec_succès' => Complaint::where('status', 'avec_succès')->count(),
            'refusée' => Complaint::where('status', 'refusée')->count(),
        ];

        return view('syndic.complaints.index', compact('complaints', 'counts', 'residence'));
    }

    public function show(Complaint $complaint)
    {
        $complaint->load(['apartment.building', 'resident', 'replies.user']);

        return view('syndic.complaints.show', compact('complaint'));
    }

    public function reply(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => ['required', 'in:déposée,en_attente,avec_succès,refusée'],
            'rejection_reason' => [
                'required_if:status,refusée',
                'nullable',
                'string',
                'min:5'
            ],
            'reply_content' => ['nullable', 'string'],
        ], [
            'rejection_reason.required_if' => 'La justification du refus est obligatoire lorsque vous refusez une réclamation.',
            'rejection_reason.min' => 'La justification du refus doit contenir au moins 5 caractères.',
        ]);

        $status = $request->input('status');
        $rejectionReason = $status === 'refusée' ? $request->input('rejection_reason') : null;

        $complaint->update([
            'status' => $status,
            'rejection_reason' => $rejectionReason,
        ]);

        if ($request->filled('reply_content')) {
            ComplaintReply::create([
                'complaint_id' => $complaint->id,
                'user_id' => $request->user()->id,
                'message' => $request->input('reply_content'),
            ]);
        }

        return back()->with('success', 'Le statut de la réclamation a été mis à jour avec succès.');
    }

    public function downloadPdf(Complaint $complaint)
    {
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
