<?php

namespace App\Filament\Resources\JardincitoResource\Pages;

use App\Filament\Resources\JardincitoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJardincito extends EditRecord
{
    protected static string $resource = JardincitoResource::class;

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
