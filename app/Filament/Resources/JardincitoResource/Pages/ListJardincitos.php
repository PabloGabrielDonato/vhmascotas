<?php

namespace App\Filament\Resources\JardincitoResource\Pages;

use App\Filament\Resources\JardincitoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;


class ListJardincitos extends ListRecords
{
    protected static string $resource = JardincitoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Añadir a jardincito'),
        ];
    }

    public function getTabs(): array
    {
        return[
        'Todos' => Tab::make(),
        'Lunes' => Tab::make()
        ->modifyQueryUsing(fn(Builder$query) => $query ->where('dia','=','lunes')),
        'Miercoles' => Tab::make()
        ->modifyQueryUsing(fn(Builder$query) => $query ->where('dia','=','miercoles')),
        ];
    }
}
