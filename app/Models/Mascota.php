<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mascota extends Model
{
    
    use HasFactory;
    
    public function dueño(): BelongsTo
    {
        return $this->belongsTo(Dueño::class, 'dueños_id');
    }

    public function citas():HasMany
    {
        return $this->hasMany(Citas::class);
    }
    
    public function jardincito():HasMany
    {
        return $this->hasMany(Jardincito::class);
    }
}
