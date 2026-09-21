<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name' => ['required','string','max:120'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','confirmed',Password::defaults()],
            'phone' => ['nullable','string','max:30'],
            'address' => ['nullable','string','max:500'],
            'role' => ['nullable','in:owner,vet,shelter'],
        ];
    }
}
