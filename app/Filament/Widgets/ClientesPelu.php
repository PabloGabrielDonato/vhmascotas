<?php

namespace App\Filament\Widgets;

use App\Models\Citas;
use App\Models\Mascota;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class ClientesPelu extends ChartWidget
{
    protected static ?string $heading = 'Cantidad de citas mensuales en la VH Pelu';

    protected function getData(): array
    {
        $data = $this->getCitasMensuales();

        return [
            'datasets' => [
                [
                    'label' => 'Citas registradas',
                    'data' => $data['citasMensuales']
                ]
            ],
            'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    private function getCitasMensuales(): array
    {
        $now = Carbon::now();
        $citasMensuales = [];
        
        $meses = collect(range(1, 12))->map(function ($month) use ($now, &$citasMensuales) {
            $count = Citas::whereMonth('created_at', $now->month($month))->count();
            $citasMensuales[] = $count;
            return $now->month($month)->format('M');
        })->toArray();

        return [
            'citasMensuales' => $citasMensuales,
            'Meses' => $meses
        ];
    }
}