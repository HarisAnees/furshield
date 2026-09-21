<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Shelter extends Model { protected $fillable=['user_id','organization_name','description','phone','address','city','verified_at']; protected function casts():array{return ['verified_at'=>'datetime'];} public function user(){return $this->belongsTo(User::class);} public function adoptionListings(){return $this->hasMany(AdoptionListing::class);} }
