<?php

namespace App\Filament\Resources\Animal\AnimalResource\RelationManagers;

use App\Enums\Animal\SponsorshipStatusEnum;
use App\Enums\Animal\StatusEnum;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Animal\Expense;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class SponsorshipsRelationManager extends RelationManager
{
    protected static string $relationship = 'sponsorships';

    protected static ?string $title = 'Apadrinhamentos';

    protected static ?string $modelLabel = 'Apadrinhamento';

    protected static ?string $pluralModelLabel = 'Apadrinhamentos';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Apoiador')
                    ->relationship('user', 'name')
                    ->preload()
                    ->searchable()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('expense_id')
                    ->label('Tipo da Depesa')
                    ->options(
                        Expense::where('animal_id', $this->getOwnerRecord()->id) 
                            ->get()
                            ->mapWithKeys(fn ($expense) => [
                                $expense->id => "{$expense->type->getLabel()} - R$ " . number_format($expense->amount, 2, ',', '.')
                            ])
                            ->toArray()
                    ),
                Forms\Components\TextInput::make('amount')
                    ->label('Valor')
                    ->required()
                    ->prefix('R$')
                    ->numeric(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options(SponsorshipStatusEnum::class)
                    ->required(),
                Forms\Components\TextInput::make('notes')
                    ->label('Anotações')
                    ->columnSpanFull(),                    
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nome do apoiador'),
                Tables\Columns\TextColumn::make('expense.type')
                    ->label('Tipo da Despesa'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Valor')
                    ->money('BRL'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                ])
                ->icon('heroicon-m-ellipsis-horizontal'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
