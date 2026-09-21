<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Pet extends Model {
 use HasFactory;
 protected $fillable=['user_id','name','species','breed','date_of_birth','sex','weight_kg','microchip_number','notes','image_path'];
 protected function casts():array{return ['date_of_birth'=>'date','weight_kg'=>'decimal:2'];}
 public function owner(){return $this->belongsTo(User::class,'user_id');}
 public function user(){return $this->belongsTo(User::class,'user_id');}
 public function healthRecords(){return $this->hasMany(HealthRecord::class);}
 public function medicalDocuments(){return $this->hasMany(MedicalDocument::class);}
 public function appointments(){return $this->hasMany(Appointment::class);}
 public function insurancePolicies(){return $this->hasMany(InsurancePolicy::class);}
}
