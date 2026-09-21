<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class AppointmentRequest extends FormRequest {
 public function authorize(): bool { return $this->user() !== null && in_array($this->user()->role,['owner','admin'],true); }
 public function rules(): array { return ['pet_id'=>'required|exists:pets,id','vet_id'=>'required|exists:vets,id','starts_at'=>'required|date|after:now','ends_at'=>'required|date|after:starts_at','reason'=>'required|string|max:1000','symptoms'=>'nullable|string|max:5000']; }
}
