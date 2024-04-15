<?php

namespace App\Filament\Resources\DueñoResource\Pages;

use App\Filament\Resources\DueñoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDueño extends EditRecord
{
    protected static string $resource = DueñoResource::class;

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
