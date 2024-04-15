<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MascotaResource\Pages;
use App\Filament\Resources\MascotaResource\RelationManagers;
use App\Models\Mascota;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;

class MascotaResource extends Resource
{
    protected static ?string $model = Mascota::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Datos')
                ->description('Datos de la mascota.')
                ->schema([
            
            FileUpload::make('avatar')
            ->image()
            ->imageEditor(),

            TextInput::make('nombre')
            ->required(),
            
            TextInput::make('direccion')
            ->label('Direccion para traslado')
            ->required(),
            
            DatePicker::make('fecha_nacimiento')
            ->native(false)
            ->displayFormat('d m Y')
            ->required(),
            
            Select::make('especie')
            ->native(false)
            ->options([
                'Perro'=>'Perro',  
                'Gato'=>'Gato', 
            ]),

            TextInput::make('raza')
            ->required(),

            Select::make('dueños_id')
            ->relationship('dueño','nombre')
            ->native(false)
            ->required()
            ->searchable()
            ->preload()
            ->createOptionForm([
                    Forms\Components\TextInput::make('nombre')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('apellido')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->required(),
                ])
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                ->circular()
                ->sortable()
                ->searchable(),

                TextColumn::make('nombre')
                ->sortable()
                ->searchable(),
                
                TextColumn::make('especie')
                ->sortable()
                ->searchable(),

                TextColumn::make('fecha_nacimiento')
                ->date('d m Y')
                ->sortable()
                ->searchable(),

                TextColumn::make('dueño.nombre')
                ->label('Nombre del dueño')
                ->sortable()
                ->searchable(),
            ])->paginated(false)


            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListMascotas::route('/'),
            'create' => Pages\CreateMascota::route('/create'),
            'edit' => Pages\EditMascota::route('/{record}/edit'),
        ];
    }
}