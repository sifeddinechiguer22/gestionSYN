<?php

namespace App\Http\Controllers\Syndic;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Payment;
use App\Models\Apartment;
use App\Models\Building;
use Illuminate\Http\Request;
use App\Notifications\ApplicationNotification;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $residenceId = $request->user()->managedResidence?->id;
        $query = Payment::with(['apartment.building', 'payer'])
            ->whereHas('apartment.building', fn ($buildingQuery) => $buildingQuery->where('residence_id', $residenceId));

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('receipt_number', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%")
                  ->orWhereHas('payer', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('apartment', function ($a) use ($search) {
                      $a->where('number', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('building')) {
            $buildingId = $request->input('building');
            $query->whereHas('apartment', function ($a) use ($buildingId) {
                $a->where('building_id', $buildingId);
            });
        }

        if ($request->filled('month')) {
            $query->where('month', $request->input('month'));
        }

        $payments = $query->latest('payment_date')->paginate(10)->withQueryString();
        $buildings = Building::where('residence_id', $residenceId)->get();

        return view('syndic.payments.index', compact('payments', 'buildings'));
    }

    public function create()
    {
        $apartments = Apartment::with(['building', 'resident'])->get();

        return view('syndic.payments.create', compact('apartments'));
    }

    public function store(StorePaymentRequest $request)
    {
        $data = $request->validated();
        
        $apartment = Apartment::findOrFail($data['apartment_id']);
        $data['user_id'] = $apartment->user_id ?? $request->user()->id;
        $data['receipt_number'] = 'REC-' . date('Y') . '-' . str_pad((string)(Payment::count() + 1), 3, '0', STR_PAD_LEFT);

        if ($request->hasFile('proof_file')) {
            $data['proof_file'] = $request->file('proof_file')->store('receipts', 'public');
        }

        $payment = Payment::create($data);

        $apartment->resident?->notify(new ApplicationNotification(
            'Nouveau paiement enregistré',
            'Un paiement de ' . number_format((float) $payment->amount, 2, ',', ' ') . ' DH a été enregistré pour votre appartement.',
            'payment',
            route('resident.notifications')
        ));

        return redirect()->route('syndic.payments.index')->with('success', 'Paiement enregistré et reçu généré avec succès.');
    }

    public function approve(Request $request, Payment $payment)
    {
        $this->ensureManagedPayment($request, $payment);

        abort_unless($payment->status === 'pending', 422, 'Seuls les paiements en attente peuvent être validés.');

        $payment->update([
            'status' => 'paid',
            'notes' => trim(($payment->notes ? $payment->notes . ' ' : '') . 'Paiement validé par le syndic le ' . now()->format('d/m/Y H:i') . '.'),
        ]);

        $payment->payer?->notify(new ApplicationNotification(
            'Paiement validé',
            'Votre paiement de ' . number_format((float) $payment->amount, 2, ',', ' ') . ' DH a été validé par le syndic.',
            'payment-approved',
            route('resident.notifications')
        ));

        return back()->with('success', 'Paiement validé. Le résident a été informé.');
    }

    public function cancel(Request $request, Payment $payment)
    {
        $this->ensureManagedPayment($request, $payment);

        abort_unless($payment->status === 'pending', 422, 'Seuls les paiements en attente peuvent être annulés.');

        $payment->update([
            'status' => 'cancelled',
            'notes' => trim(($payment->notes ? $payment->notes . ' ' : '') . 'Paiement annulé par le syndic le ' . now()->format('d/m/Y H:i') . '.'),
        ]);

        $payment->payer?->notify(new ApplicationNotification(
            'Paiement annulé',
            'Votre déclaration de paiement a été annulée par le syndic.',
            'payment-cancelled',
            route('resident.notifications')
        ));

        return back()->with('success', 'Paiement annulé. Le résident a été informé.');
    }

    private function ensureManagedPayment(Request $request, Payment $payment): void
    {
        $residenceId = $request->user()->managedResidence?->id;

        abort_unless(
            $payment->apartment()->whereHas('building', fn ($query) => $query->where('residence_id', $residenceId))->exists(),
            403,
            'Ce paiement n’appartient pas à votre résidence.'
        );
    }

    public function downloadReceipt(Request $request, Payment $payment)
    {
        $user = $request->user();

        if (! $user->isSyndic() && $payment->user_id !== $user->id && optional($payment->apartment)->user_id !== $user->id) {
            abort(403, 'Accès non autorisé à ce reçu.');
        }

        $payment->load(['apartment.building', 'payer']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.receipt', compact('payment'));

        return $pdf->download('Recu-' . $payment->receipt_number . '.pdf');
    }
}
