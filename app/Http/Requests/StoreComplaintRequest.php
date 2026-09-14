<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComplaintRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'apartment_id' => ['nullable', 'exists:apartments,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'in:plumbing,elevator,electricity,noise,cleanliness,other'],
            'priority' => ['nullable', 'in:low,medium,high,urgent'],
            'description' => ['required', 'string', 'min:5'],
            'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ];
    }
}
