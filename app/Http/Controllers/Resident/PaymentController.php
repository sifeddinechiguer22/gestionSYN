<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

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
}
