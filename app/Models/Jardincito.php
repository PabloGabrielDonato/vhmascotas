<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jardincito extends Model
{
    use HasFactory;

    public function mascotas(): BelongsTo
    {
        return $this->belongsTo(Mascota::class);
    }
}
