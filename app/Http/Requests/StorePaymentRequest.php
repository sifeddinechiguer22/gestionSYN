<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isSyndic();
    }

    public function rules(): array
    {
        return [
            'apartment_id' => ['required', 'exists:apartments,id'],
            'amount' => ['required', 'numeric', 'min:1'],
            'month' => ['required', 'string'],
            'payment_date' => ['required', 'date'],
            'payment_method' => ['required', 'in:virement,especes,cheque,carte'],
            'status' => ['required', 'in:paid,pending,late'],
            'reference' => ['nullable', 'string', 'max:255'],
            'proof_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
