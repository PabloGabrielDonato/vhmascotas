<?php

namespace App\Filament\Resources\CitasResource\Pages;

use App\Filament\Resources\CitasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListCitas extends ListRecords
{
    protected static string $resource = CitasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Agendar cita'),
        ];
    }

    public function getTabs(): array
    {
        return[
        'Todos' => Tab::make(),
        'Mensuales' => Tab::make()
        ->modifyQueryUsing(fn(Builder$query) => $query ->where('condicion','=','mensual')),
        'Pagos sueltos' => Tab::make()
        ->modifyQueryUsing(fn(Builder$query) => $query ->where('condicion','=','suelto')),
        ];
    }

    
}
