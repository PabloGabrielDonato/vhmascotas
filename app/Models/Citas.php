<?php

namespace App\Models;


use App\Enums\CitasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Citas extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => CitasStatus::class
    ];

    public function mascotas(): BelongsTo
    {
        return $this->belongsTo(Mascota::class);
    }
    
}
