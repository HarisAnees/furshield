<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Vet extends Model {
 protected $fillable=['user_id','specialization','experience_years','bio','clinic_name','address','city','latitude','longitude','is_available'];
 protected function casts():array{return ['is_available'=>'boolean'];}
 public function user(){return $this->belongsTo(User::class);}
 public function appointments(){return $this->hasMany(Appointment::class);}
 public function availabilities(){return $this->hasMany(VetAvailability::class);}
}
