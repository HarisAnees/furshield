<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable {
 use HasApiTokens,HasFactory,Notifiable;
 protected $fillable=['name','email','password','phone','address','role','is_active'];
 protected $hidden=['password','remember_token'];
 protected function casts():array{return ['email_verified_at'=>'datetime','password'=>'hashed','is_active'=>'boolean'];}
 public function pets(){return $this->hasMany(Pet::class,'user_id');}
 public function appointments(){return $this->hasMany(Appointment::class);}
 public function vetProfile(){return $this->hasOne(Vet::class);}
 public function shelterProfile(){return $this->hasOne(Shelter::class);}
 public function adoptionInterests(){return $this->hasMany(AdoptionInterest::class);}
 public function cart(){return $this->hasOne(Cart::class);}
 public function orders(){return $this->hasMany(Order::class);}
 public function familyMembers(){return $this->hasMany(FamilyMember::class,'owner_id');}
 public function familyOwners(){return $this->hasMany(FamilyMember::class,'member_id');}
 public function reminders(){return $this->hasMany(Reminder::class);}
 public function auditLogs(){return $this->hasMany(AuditLog::class);}
}
