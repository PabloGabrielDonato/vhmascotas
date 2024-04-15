<?php

namespace App\Filament\Resources\MascotaResource\Pages;

use App\Filament\Resources\MascotaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMascota extends CreateRecord
{
    protected static string $resource = MascotaResource::class;

    protected function getRedirectUrl(): string
    {
        
        return $this->getResource()::getUrl('index');
    }
    
}
