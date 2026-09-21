<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class AdoptionListingRequest extends FormRequest { public function authorize():bool{return $this->user()?->role==='shelter';} public function rules():array{return ['pet_name'=>'required|string|max:255','species'=>'required|string|max:100','breed'=>'nullable|string|max:100','age_text'=>'nullable|string|max:100','sex'=>'nullable|string|max:50','health_summary'=>'nullable|string','care_summary'=>'nullable|string','status'=>'sometimes|in:available,hold,adopted','image_path'=>'nullable|string|max:1000'];} }
