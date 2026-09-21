<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalDocument extends Model
{
    protected $fillable = ['pet_id','title','document_type','file_path','mime_type','file_size'];

    public function pet() { return $this->belongsTo(Pet::class); }
}
