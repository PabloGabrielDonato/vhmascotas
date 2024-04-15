<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JardincitoResource\Pages;
use App\Filament\Resources\JardincitoResource\RelationManagers;
use App\Models\Jardincito;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class JardincitoResource extends Resource
{
    protected static ?string $model = Jardincito::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationGroup = 'VH Jardincito';

    protected static ?string $navigationLabel = 'Jardincito VH';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Datos')
                ->description('Datos del Jardincito.')
                ->schema([


                    Select::make('mascotas_id')
                    ->label('Animales')
                    ->relationship('mascotas', 'nombre')
                    ->preload()
                    ->searchable()
                    ->native(false),


                    Select::make('dia')
                    ->options(['Lunes' => 'Lunes','Miércoles'=>'Miércoles'])
                    ->preload()
                    ->searchable()
                    ->native(false),

                    TimePicker::make('hora_inicio')
                    ->required()
                    ->seconds(false),

                    TimePicker::make('hora_finalizacion')
                    ->required()
                    ->seconds(false),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('mascotas.nombre')
                ->sortable()
                ->searchable(),
                
                TextColumn::make('dia')
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
                
                TextColumn::make('mascotas.direccion')
                ->label('Direccion traslado')
                ->sortable()
                ->searchable(),
            ])
            ->filters([
                SelectFilter::make('dia')
                ->options([
                'lunes' => 'lunes',
                'miercoles' => 'miercoles',
            ])
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
            'index' => Pages\ListJardincitos::route('/'),
            'create' => Pages\CreateJardincito::route('/create'),
            'edit' => Pages\EditJardincito::route('/{record}/edit'),
        ];
    }
}
