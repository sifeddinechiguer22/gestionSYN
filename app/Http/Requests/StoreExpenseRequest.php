<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isSyndic();
    }

    public function rules(): array
    {
        return [
            'residence_id' => ['required', 'exists:residences,id'],
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:maintenance,electricity,water,cleaning,security,repairs,other'],
            'amount' => ['required', 'numeric', 'min:1'],
            'expense_date' => ['required', 'date'],
            'vendor_name' => ['nullable', 'string', 'max:255'],
            'receipt_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'description' => ['nullable', 'string'],
        ];
    }
}
