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

class CitasResource extends Resource
{
    protected static ?string $model = Citas::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('fecha')
                ->required(),

                TimePicker::make('hora_inicio')
                ->required()
                ->seconds(false)
                ->native(false),

                TimePicker::make('hora_finalizacion')
                ->required()
                ->seconds(false)
                ->native(false),

                TextInput::make('description')
                ->label('Descripción')
                ->required(),

                Select::make('mascotas_id')
                ->relationship('mascotas', 'nombre')
                ->preload()
                ->searchable()
                ->native(false),
                
                Select::make('status')
                ->label('Estado de la cita')
                ->options(CitasStatus::class)
                ->native(false)
                ->visibleOn(Pages\EditCitas::class),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table ->paginated(false)
            ->columns([
                TextColumn::make('mascotas.nombre')
                ->sortable()
                ->searchable(),

                TextColumn::make('fecha')
                ->date('d M Y')
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

                TextColumn::make('mascotas.direccion')
                ->label('Direccion traslado')
                ->sortable()
                ->searchable(),
            ])->defaultSort('hora_inicio', 'asc')
            ->filters([
                Filter::make('citas_de_hoy')
                ->default(true)
                ->query(function (Builder $query) {
                    $today = Carbon::today();
                    return $query->whereDate('fecha', $today);
                })
            ])
            ->actions([
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
}