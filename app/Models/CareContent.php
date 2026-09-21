<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareContent extends Model
{
    protected $fillable = ['title','slug','category','content','video_url','is_published'];
    protected function casts(): array { return ['is_published' => 'boolean']; }
}
