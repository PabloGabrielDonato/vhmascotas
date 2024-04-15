<?php

namespace App\Filament\Resources\CitasResource\Pages;

use App\Filament\Resources\CitasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCitas extends EditRecord
{
    protected static string $resource = CitasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        
        return $this->getResource()::getUrl('index');
    }
}
