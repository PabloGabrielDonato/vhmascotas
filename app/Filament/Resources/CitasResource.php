<?php

namespace App\Filament\Resources;


use App\Filament\Resources\CitasResource\Pages;
use App\Filament\Resources\CitasResource\RelationManagers;
use App\Models\Citas;
use App\Enums\CitasStatus;
use Illuminate\Support\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Section;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;

class CitasResource extends Resource
{
    protected static ?string $model = Citas::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'VH Pelu';

    

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Datos')
                ->description('Datos de la cita.')
                ->schema([
                DatePicker::make('fecha')
                ->required(),

                TimePicker::make('hora_inicio')
                ->required()
                ->seconds(false),

                TimePicker::make('hora_finalizacion')
                ->required()
                ->seconds(false),

                Select::make('mascotas_id')
                ->relationship('mascotas', 'nombre')
                ->preload()
                ->searchable()
                ->native(false),
                
                Select::make('servicios')
                ->label('Servicios a realizar')
                ->options([
                    'educacion_personalizada' => 'Educación personalizada',
                    'evaluacion_adaptacion' => 'Evaluación y Adaptación (esto es para hospedaje jardín y Jardincito)',
                    'peluqueria_bano_arreglos' => 'Peluquería: Baño y arreglos',
                    'peluqueria_bano_deslanado' => 'Peluquería: Baño y deslanado',
                    'peluqueria_bano_corte' => 'Peluquería: Baño y corte',
                    'peluqueria_bano_desanudado_corte' => 'Peluquería: Baño, desanudado y corte',
                    'corte_unas' => 'Corte de uñas',
                    'corte' => 'Corte',
                ])
                ->required()
                ->native(false)
                ->searchable(),

                TextInput::make('description')
                ->label('Observaciones')
                ->required(),

                Select::make('condicion')
                ->options([
                    'mensual' => 'mensual',
                    'suelto' => 'suelto',
                ])
                ->native(false),
                
                Select::make('status')
                ->label('Estado de la cita')
                ->options(CitasStatus::class)
                ->native(false)
                ->visibleOn(Pages\EditCitas::class),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table ->paginated(false)
            ->columns([
                TextColumn::make('mascotas.nombre')
                ->label('Animal')
                ->sortable()
                ->searchable(),

                TextColumn::make('fecha')
                ->date('D d M')
                ->sortable()
                ->searchable(),

                TextColumn::make('hora_inicio')
                ->time('h:i A')
                ->sortable()
                ->searchable(),
                
                TextColumn::make('hora_finalizacion')
                ->time('h:i A')
                ->sortable()
                ->searchable(),
                
                TextColumn::make('description')
                ->label('Descripcion')
                ->sortable()
                ->searchable(),

                TextColumn::make('status')
                ->label('Estado')
                ->badge()
                ->sortable(),

                TextColumn::make('condicion')
                ->label('Turno')
                ->sortable()
                ->searchable(),
            ])->defaultSort('hora_inicio', 'asc')
            ->filters([
                Filter::make('citas_de_hoy')
                    ->default(true)
                    ->query(function (Builder $query) {
                        $query->whereDate('fecha', Carbon::today());
                    }),
            ], layout: FiltersLayout::AboveContent)->filtersFormColumns(3)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('Confirmar')
                    ->action(function(Citas $record){
                        $record->status = CitasStatus::Confirmada;
                        $record->save();
                    })
                    ->visible(fn($record) => $record->status != CitasStatus::Confirmada)
                    ->color('success')
                    ->icon('heroicon-o-check-circle'),
                
                    Tables\Actions\Action::make('Cancelar')
                    ->action(function(Citas $record){
                        $record->status = CitasStatus::Cancelada;
                        $record->save();
                    })
                    ->visible(fn($record) => $record->status != CitasStatus::Cancelada)
                    ->color('danger')
                    ->icon('heroicon-o-x-circle'),
                ])
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCitas::route('/'),
            'create' => Pages\CreateCitas::route('/create'),
            'edit' => Pages\EditCitas::route('/{record}/edit'),
        ];
    }

    //Contador en barra lateral.
    public static function getNavigationBadge():?string
{
    return Citas::whereDate('fecha', Carbon::today())->count();
}
}
