<?php

namespace App\Filament\Resources\DueñoResource\Pages;

use App\Filament\Resources\DueñoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDueño extends CreateRecord
{
    protected static string $resource = DueñoResource::class;

    protected function getRedirectUrl(): string
    {
        
        return $this->getResource()::getUrl('index');
    }
}
