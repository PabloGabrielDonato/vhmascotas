<?php

namespace App\Filament\Widgets;

use App\Models\Jardincito;
use App\Models\Mascota;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AnimalesJardin extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(label:'Total Aniamales en jardincito', value: Jardincito::count())

            ->description('Cantidad de animales registrados en el jardincito')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success')
            ->chart([7,3,4,5,6,8,18,29]),
            
            Stat::make(label:'Total Aniamales en jardincito de los lunes', value: Jardincito::where('dia', 'lunes')->count())

            ->description('Cantidad de animales registrados en el jardincito de los lunes')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success')
            ->chart([7,3,4,5,6,8,18,29]),
            
            Stat::make(label:'Total Aniamales en jardincito los miércoles', value: Jardincito::where('dia', 'lunes')->count())

            ->description('Cantidad de animales registrados en el jardincito de los miércoles')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success')
            ->chart([7,3,4,5,6,8,18,29]),
        ];
    }
}
