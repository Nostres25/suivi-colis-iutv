<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Commandes';

    /**
     * Définit la structure  du formulaire d'édition.
     * Applique une validation stricte des types (numeric, required) avant
     * l'insertion en base pour prévenir les injections et garantir l'intégrité des données.
     *
     * @param Form $form Le constructeur de formulaire injecté par Filament
     * @return Form Le formulaire configuré avec les contraintes de sécurité
     */

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Détails')->schema([
                    Forms\Components\TextInput::make('order_num')
                        ->label('N° Commande')
                        ->required(),
                    
                    Forms\Components\TextInput::make('label')
                        ->label('Libellé')
                        ->required(),

                    
                    Forms\Components\TextInput::make('cost')
                        ->label('Coût')
                        ->numeric() 
                        ->prefix('€'),

                    Forms\Components\Select::make('state')
                        ->label('État')
                        ->options([
                            'BROUILLON' => 'Brouillon',
                            'DEVIS' => 'Devis',
                            'COMMANDE' => 'Commande',
                            'LIVRE_ET_PAYE' => 'Livré',
                        ])
                        ->required(),
                ])->columns(2),
            ]);
    }

    /**
     * Définit les colonnes et le comportement du tableau.
     * Utilise la pagination côté serveur et l'indexation SQL via searchable() .
     *
     * @param Table $table Le constructeur de tableau injecté par Filament
     * @return Table Le tableau optimisé pour le grand volume de données
     */

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_num')
                    ->label('N°')
                    ->sortable()
                    ->searchable(), 

                Tables\Columns\TextColumn::make('label')
                    ->label('Libellé')
                    ->searchable(),

                Tables\Columns\TextColumn::make('cost')
                    ->money('EUR')
                    ->label('Coût'),

                Tables\Columns\TextColumn::make('state')
                    ->badge()
                    ->label('État'),
            ])
            ->filters([])
            ->actions([ Tables\Actions\EditAction::make() ])
            ->bulkActions([ Tables\Actions\DeleteBulkAction::make() ]);
    }

    public static function getRelations(): array { return []; }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
