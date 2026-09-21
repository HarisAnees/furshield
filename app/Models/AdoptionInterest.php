<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AdoptionInterest extends Model { protected $fillable=['adoption_listing_id','user_id','message','status']; public function listing(){return $this->belongsTo(AdoptionListing::class,'adoption_listing_id');} public function user(){return $this->belongsTo(User::class);} }
