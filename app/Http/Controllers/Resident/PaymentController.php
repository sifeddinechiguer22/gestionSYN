<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Notifications\ApplicationNotification;

class PaymentController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $payments = Payment::where('user_id', $user->id)
            ->latest('payment_date')
            ->paginate(10);

        return view('resident.payments.index', compact('payments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'month' => ['required', 'string', 'max:30'],
            'payment_method' => ['required', 'in:virement,especes,cheque,carte'],
            'payment_date' => ['required', 'date'],
            'proof_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'confirmation' => ['accepted'],
        ], [
            'confirmation.accepted' => 'Vous devez confirmer que le paiement a bien été effectué.',
        ]);

        $apartment = $request->user()->apartment;

        if (!$apartment) {
            throw ValidationException::withMessages([
                'amount' => 'Aucun appartement n’est associé à votre compte.',
            ]);
        }

        $proofPath = $request->hasFile('proof_file')
            ? $request->file('proof_file')->store('receipts', 'public')
            : null;

        $payment = Payment::create([
            'apartment_id' => $apartment->id,
            'user_id' => $request->user()->id,
            'receipt_number' => 'DECL-' . now()->format('YmdHis') . '-' . $request->user()->id,
            'amount' => $data['amount'],
            'month' => $data['month'],
            'payment_date' => $data['payment_date'],
            'payment_method' => $data['payment_method'],
            'status' => 'pending',
            'proof_file' => $proofPath,
            'notes' => 'Déclaration de paiement envoyée par le résident, en attente de validation du syndic.',
        ]);

        $apartment->building->residence->syndic?->notify(new ApplicationNotification(
            'Nouveau paiement à valider',
            $request->user()->name . ' a déclaré un paiement de ' . number_format((float) $data['amount'], 2, ',', ' ') . ' DH.',
            'payment',
            route('syndic.notifications')
        ));

        return redirect()->route('resident.payments')->with('success', 'Votre reçu a été envoyé au syndic pour validation.');
    }
}
