<?php

namespace App\Enums;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CitasStatus: string implements HasLabel, HasColor{
    case Creada = 'Creada';
    case Confirmada = 'Confirmada';
    case Cancelada = 'Cancelada';


    public function getLabel(): ?string
    {
        return match ($this){
            self::Creada => 'Creada',
            self::Confirmada => 'Confirmada',
            self::Cancelada => 'Cancelada',
        };
    }

    public function getColor(): ?string
    {
        return match ($this){
            self::Creada => 'warning',
            self::Confirmada => 'success',
            self::Cancelada => 'danger',
        };
    }
}