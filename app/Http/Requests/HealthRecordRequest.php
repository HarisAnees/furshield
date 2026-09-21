<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class HealthRecordRequest extends FormRequest { public function authorize():bool{return $this->user()!==null;} public function rules():array{return ['pet_id'=>'required|exists:pets,id','record_type'=>'required|in:vaccination,allergy,illness,treatment,checkup,other','title'=>'required|string|max:200','description'=>'nullable|string|max:5000','recorded_at'=>'required|date','provider_name'=>'nullable|string|max:200','medication'=>'nullable|string|max:2000','follow_up_at'=>'nullable|date'];} }
