<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationLabel = 'Colis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('order_id')
                    ->relationship('order', 'label') 
                    ->label('Commande liée')
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('label')
                    ->label('Nom du Colis')
                    ->required(),

                Forms\Components\TextInput::make('cost')
                    ->numeric()
                    ->label('Coût'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.label')
                    ->label('Commande')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('label')
                    ->label('Colis')
                    ->searchable(),

                Tables\Columns\TextColumn::make('cost')
                    ->money('EUR'),
            ])
            ->filters([])
            ->actions([ Tables\Actions\EditAction::make() ])
            ->bulkActions([ Tables\Actions\DeleteBulkAction::make() ]);
    }

    public static function getRelations(): array { return []; }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}
