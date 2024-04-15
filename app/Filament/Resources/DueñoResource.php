<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DueñoResource\Pages;
use App\Filament\Resources\DueñoResource\RelationManagers;
use App\Models\Dueño;
use App\Models\Mascota;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;

class DueñoResource extends Resource
{
    protected static ?string $model = Dueño::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Gestión';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Datos')
                    ->description('Datos personales del dueño')
                    ->schema([
                TextInput::make('nombre')
                ->required(),

                TextInput::make('apellido')
                ->required(),
                TextInput::make('phone')
                ->label('Teléfono')
                ->tel()
                ->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('nombre')
                ->label('Nombre')
                ->sortable()
                ->searchable(),
                
                TextColumn::make('apellido')
                ->label('Apellido')
                ->sortable()
                ->searchable(),

                TextColumn::make('phone')
                ->label('Teléfono')
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
            'index' => Pages\ListDueños::route('/'),
            'create' => Pages\CreateDueño::route('/create'),
            'edit' => Pages\EditDueño::route('/{record}/edit'),
        ];
    }

    //Contador en barra lateral.
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
