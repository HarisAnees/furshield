<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HealthRecord extends Model {
 protected $fillable=['pet_id','record_type','title','description','recorded_at','provider_name','medication','follow_up_at'];
 protected function casts():array{return ['recorded_at'=>'datetime','follow_up_at'=>'datetime'];}
 public function pet(){return $this->belongsTo(Pet::class);}
}
