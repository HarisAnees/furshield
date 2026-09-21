<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AdoptionListing extends Model {
 protected $fillable=['shelter_id','pet_name','species','breed','age_text','sex','health_summary','care_summary','status','image_path'];
 public function shelter(){return $this->belongsTo(Shelter::class);}
 public function interests(){return $this->hasMany(AdoptionInterest::class);}
 public function careLogs(){return $this->hasMany(ShelterCareLog::class);}
}
