<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MascotaResource\Pages;
use App\Filament\Resources\MascotaResource\RelationManagers;
use App\Models\Mascota;
use Filament\Tables\Actions\Action;
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
use Filament\Forms\Components\Wizard;
use Filament\Tables\Columns\SelectColumn;

class MascotaResource extends Resource
{
    protected static ?string $model = Mascota::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationLabel = 'Animales :D';

    protected static ?string $navigationGroup = 'Gestión';

    public static function form(Form $form): Form
    {
        return $form
        ->columns(1)
        ->schema([
            Wizard::make([
                Wizard\Step::make('Datos del animal.')
                    ->schema([
                        FileUpload::make('avatar')
                        ->image()
                        ->directory('avatars')
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
                        ->label('Tutor')
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
                        Forms\Components\TextInput::make('email')
                            ->label('Correo electrónico')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('Teléfono')
                            ->tel()
                            ->required(),
                            ])
                        ]),
                Wizard\Step::make('Ficha médica')
                ->schema([

                    DatePicker::make('sextuple')
                        ->label('Fecha vencimiento sextuple')
                        ->displayFormat('d m Y')
                        ->required(),
                    DatePicker::make('antirrabica')
                        ->label('Fecha vencimiento antirrabica')
                        ->displayFormat('d m Y')
                        ->required(),
                    DatePicker::make('bordetella')
                        ->label('Fecha vencimiento bordetella')
                        ->displayFormat('d m Y')
                        ->required(),

                    Forms\Components\TextInput::make('alergias'),

                    Select::make('sociable_perros')
                    ->native(false)
                    ->options([
                        'si'=>'si',  
                        'no'=>'no', 
                        ]),
                    Select::make('sociable_humanos')
                    ->native(false)
                    ->options([
                        'si'=>'si',  
                        'no'=>'no', 
                        ]),
                    Select::make('castracion')
                    ->native(false)
                    ->options([
                        'si'=>'si',  
                        'no'=>'no', 
                        ]),                    
                    Forms\Components\TextInput::make('observaciones'),


                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        
        return $table
        ->emptyStateHeading('No hay animales registrados.')
            ->emptyStateDescription('Una vez que cargues uno, aparecera en esta tabla.')
            ->emptyStateIcon('heroicon-o-heart')
            ->emptyStateActions([
                Action::make('create')
                    ->label('Registrar un nuevo animal.')
                    ->url(route('filament.admin.resources.mascotas.create'))
                    ->icon('heroicon-m-plus')
                    ->button(),
            ])
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

                SelectColumn::make('state')
                ->label('Estado del animal')
                ->options([
                    'activo' => 'Activo',
                    'inactivo' => 'Inactivo',
                    ])
                ->sortable()
                ->searchable(),
            ])->paginated(false)


            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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

    //Contador en barra lateral.
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
