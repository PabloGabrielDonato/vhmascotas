<?php

namespace App\Filament\Resources\MascotaResource\Pages;

use App\Filament\Resources\MascotaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListMascotas extends ListRecords
{
    protected static string $resource = MascotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Añadir animal'),
        ];
    }


    public function getTabs(): array
    {
        return[
        'Todos' => Tab::make(),
        'Perros' => Tab::make()
        ->modifyQueryUsing(fn(Builder$query) => $query ->where('especie','=','perro')),
        'Gatos' => Tab::make()
        ->modifyQueryUsing(fn(Builder$query) => $query ->where('especie','=','gato')),
        ];
    }
}
