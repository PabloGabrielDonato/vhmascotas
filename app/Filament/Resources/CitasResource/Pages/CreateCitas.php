<?php

namespace App\Filament\Resources\CitasResource\Pages;

use App\Filament\Resources\CitasResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCitas extends CreateRecord
{
    protected static string $resource = CitasResource::class;
    
    protected function getRedirectUrl(): string
    {
        
        return $this->getResource()::getUrl('index');
    }
}
