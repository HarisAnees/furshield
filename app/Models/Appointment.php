<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id','pet_id','vet_id','starts_at','ends_at','reason',
        'symptoms','status','diagnosis','medication','follow_up_notes',
    ];

    protected function casts(): array
    {
        return ['starts_at' => 'datetime', 'ends_at' => 'datetime'];
    }

    public function user() { return $this->belongsTo(User::class); }
    public function pet() { return $this->belongsTo(Pet::class); }
    public function vet() { return $this->belongsTo(Vet::class); }
}
