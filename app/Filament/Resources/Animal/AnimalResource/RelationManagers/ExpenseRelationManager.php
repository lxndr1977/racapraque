<?php

namespace App\Filament\Resources\Animal\AnimalResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\Animal\ExpenseTypeEnum;
use App\Enums\Animal\ExpenseStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\Animal\ExpenseRecurrenceEnum;
use App\Enums\Animal\ExpenseTimeStatusEnum;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ExpenseRelationManager extends RelationManager
{
    protected static string $relationship = 'expenses';

    protected static ?string $title = 'Despesas';

    protected static ?string $modelLabel = 'Depsesa';

    protected static ?string $pluralModelLabel = 'Despesas';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label('Tipo')
                    ->required()
                    ->options(ExpenseTypeEnum::class),
                Forms\Components\TextInput::make('description')
                    ->label('Descrição'),                
                Forms\Components\TextInput::make('amount')
                    ->label('Valor')
                    ->required()
                    ->numeric()
                    ->inputMode('decimal')
                    ->prefix('R$'),
                Forms\Components\Select::make('recurrence_days')
                    ->label('Recorrência')
                    ->options(ExpenseRecurrenceEnum::class)
                    ->required(),                     
                Forms\Components\DatePicker::make('start_date')
                    ->label('Inicia em')
                    ->locale('pt_BR')
                    ->live(onBlur: true)
                    ->native(false)
                    ->closeOnDateSelection()
                    ->displayFormat('d/m/Y')
                    ->minDate(today())
                    ->required(fn (Get $get): bool => filled($get('end_date')))
                    ->beforeOrEqual('end_date'), 
                Forms\Components\DatePicker::make('end_date')
                    ->label('Termina em')
                    ->locale('pt_BR')
                    ->live(onBlur: true)
                    ->native(false)
                    ->closeOnDateSelection()
                    ->displayFormat('d/m/Y')
                    ->minDate(today())
                    ->required(fn (Get $get): bool => filled($get('start_date')))
                    ->afterOrEqual('start_date'), 
                Forms\Components\TextInput::make('payment_link')
                    ->label('Link de pagamento')
                    ->columnSpanFull()
                    ->url()
                    ->required(),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->sortable(),
                Tables\Columns\TextColumn::make('recurrence_days')
                    ->label('Recorrência'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Valor')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_sponsorship')
                    ->label('Apadrinhado')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('timeStatus')
                    ->label('Duração')        
                    ->badge() 
                    ->icon(fn (ExpenseTimeStatusEnum $state): string => $state->getIcon()),                     
                Tables\Columns\TextColumn::make('status')
                    ->label('Situação')        
                    ->badge() 
                    ->icon(fn (ExpenseStatusEnum $state): string => $state->getIcon()),            ])
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
