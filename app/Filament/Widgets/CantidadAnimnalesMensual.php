<?php

namespace App\Filament\Widgets;


use Filament\Widgets\ChartWidget;
use App\Models\Mascota;
use Carbon\Carbon;

class CantidadAnimnalesMensual extends ChartWidget
{
    protected static ?string $heading = 'Cantidad de animales anotados por mes.';

    protected function getData(): array
    {
        $data = $this->getAnimalesMensuales();

        return [
            'datasets' => [
                [
                    'label' => 'Animales registrados',
                    'data' => $data['animalesMensuales']
                ]
            ],
            'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    private function getAnimalesMensuales(): array
    {
        $now = Carbon::now()->locale('es');
        $animalesMensuales = [];
        
        $meses = collect(range(1, 12))->map(function ($month) use ($now, &$animalesMensuales) {
            $count = Mascota::whereMonth('created_at', $now->month($month))->count();
            $animalesMensuales[] = $count;
            return $now->month($month)->format('M');
        })->toArray();

        return [
            'animalesMensuales' => $animalesMensuales,
            'Meses' => $meses
        ];
    }
}
