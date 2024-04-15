<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dueño extends Model
{
    use HasFactory;

    public function mascotas():HasMany
    {
        return $this->hasMany(Mascota::class);
    }
}
