<?php

namespace App\Filament\Resources\JardincitoResource\Pages;

use App\Filament\Resources\JardincitoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJardincitos extends ListRecords
{
    protected static string $resource = JardincitoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
