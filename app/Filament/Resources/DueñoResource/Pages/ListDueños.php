<?php

namespace App\Filament\Resources\DueñoResource\Pages;

use App\Filament\Resources\DueñoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDueños extends ListRecords
{
    protected static string $resource = DueñoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Cargar nuevo Tutor'),
        ];
    }
}
