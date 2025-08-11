<?php

namespace App\Filament\Resources\Animal;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Animal\Expense;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Models\Animal\Sponsorship;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use App\Enums\Animal\SponsorshipStatusEnum;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Animal\SponsorshipResource\Pages;
use App\Filament\Resources\Animal\SponsorshipResource\RelationManagers;

class SponsorshipResource extends Resource
{
    protected static ?string $model = Sponsorship::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Apadrinhamento';

    protected static ?string $pluralModelLabel = 'Apadrinhamentos';

    protected static ?string $slug = 'apadrinhamentos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([ 
                Forms\Components\Section::make('Informações do apadrinhamento')
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->label('Apoiador')
                        ->relationship('user', 'name')
                        ->preload()
                        ->searchable()
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\Select::make('animal_id')
                        ->relationship('animal', 'name')
                        ->preload()
                        ->searchable()
                        ->required()
                        ->live()            
                        ->afterStateUpdated(function ($state, $set) {
                            $set('expense_id', null);  
                        }),
                    Forms\Components\Select::make('expense_id')
                        ->label('Despesa')
                        ->options(function (Get $get) {
                            return Expense::query()
                                ->where('animal_id', $get('animal_id')) 
                                ->get() 
                                ->mapWithKeys(fn ($expense) => [
                                    $expense->id => "{$expense->type->getLabel()} - R$ " . number_format($expense->amount, 2, ',', '.')
                                ])
                                ->toArray();
                        })
                        ->live()
                        ->required(),
                    Forms\Components\TextInput::make('amount')
                        ->label('Valor')
                        ->required()
                        ->prefix('R$')
                        ->numeric(),
                    Forms\Components\Select::make('status')
                        ->options(SponsorshipStatusEnum::class)
                        ->label('Status')
                        ->required()
                        ->default(SponsorshipStatusEnum::Active),
                    Forms\Components\TextInput::make('notes')
                        ->label('Notas')
                        ->maxLength(255)
                        ->default(null),
                ])
                ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Apoiador')
                    ->sortable(),
                Tables\Columns\TextColumn::make('animal.name')
                    ->label('Abrigado')
                    ->sortable(),
                Tables\Columns\TextColumn::make('expense.type')
                    ->label('Despesa')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Valor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->sortable()
                    ->since(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                ->icon('heroicon-o-ellipsis-horizontal')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informações do apadrinhamento')
                    ->schema([
                        TextEntry::make('animal.name')
                            ->label('Abrigado'),
                        TextEntry::make('user.name')
                            ->label('Apoiador'),
                        TextEntry::make('expense.type')
                            ->label('Despesa'),
                        TextEntry::make('expense.amount')
                            ->label('Valor da despesa'),
                        TextEntry::make('expense.recurrence_days')
                            ->label('Recorrência'),
                        TextEntry::make('amount')
                            ->label('Valor do apadrinhamento'), 
                        TextEntry::make('status')
                            ->label('Status'),                           
                        TextEntry::make('created_at')
                            ->label('Criado')
                            ->since(),                            
                        TextEntry::make('updated_at')
                            ->label('Atualizado')
                            ->since(), 
                    ])
                    ->columns(2)
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
            'index' => Pages\ListSponsorships::route('/'),
            'create' => Pages\CreateSponsorship::route('/create'),
            'view' => Pages\ViewSponsorship::route('/{record}'),
            'edit' => Pages\EditSponsorship::route('/{record}/edit'),
        ];
    }
}
