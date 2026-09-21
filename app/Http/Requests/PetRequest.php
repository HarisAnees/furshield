<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PetRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name' => ['required','string','max:120'],
            'species' => ['required','string','max:80'],
            'breed' => ['nullable','string','max:120'],
            'date_of_birth' => ['nullable','date','before_or_equal:today'],
            'sex' => ['nullable','in:male,female,unknown'],
            'weight_kg' => ['nullable','numeric','min:0','max:500'],
            'microchip_number' => ['nullable','string','max:100'],
            'notes' => ['nullable','string','max:5000'],
            'image' => ['nullable','image','max:5120'],
        ];
    }
}
