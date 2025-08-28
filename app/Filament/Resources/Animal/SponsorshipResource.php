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
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\Group;
use Filament\Tables\Columns\Layout\Split;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use App\Enums\Animal\SponsorshipStatusEnum;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use App\Filament\Resources\Animal\SponsorshipResource\Pages;
use App\Filament\Resources\Animal\SponsorshipResource\RelationManagers;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Widgets\StatsOverviewWidget\Stat;

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
                           ->mapWithKeys(fn($expense) => [
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
            Split::make([
               // Coluna esquerda
               Stack::make([
                  Tables\Columns\TextColumn::make('animal.name')
                     ->label('Abrigado')
                     ->sortable()
                     ->searchable()
                     ->weight('bold'),

                  Tables\Columns\TextColumn::make('user.name')
                     ->label('Apoiador')
                     ->sortable()
                     ->searchable(),


                  Tables\Columns\TextColumn::make('status')
                     ->label('Status')
                     ->searchable()
                     ->badge(),
               ])
                  ->space(1),

               // Coluna direita
               Stack::make([
                  Tables\Columns\TextColumn::make('expense.type')
                     ->label('Despesa')
                     ->sortable(),

                  Tables\Columns\TextColumn::make('amount')
                     ->label('Valor')
                     ->money('BRL')
                     ->sortable(),

                  Tables\Columns\TextColumn::make('created_at')
                     ->label('Criado em')
                     ->dateTime('d/m/Y H:i')
                     ->sortable()
                     ->since(),
               ])
                  ->space(1)
                  ->alignment('end'),

            ])
               ->from('md'), // Split só funciona em telas médias ou maiores
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
            Section::make('Informações do Apadrinhamento')
               ->description('Detalhes do animal abrigado e apoiador responsável')
               ->schema([
                  Group::make()
                     ->schema([
                        TextEntry::make('animal.name')
                           ->label('Animal Abrigado'),

                        TextEntry::make('status')
                           ->label('Status')
                           ->badge(),
                     ])
                     ->columns(2),
               ])
               ->collapsible()
               ->persistCollapsed()
               ->columns(1),

            Section::make('Dados do Apoiador')
               ->description('Informações de contato e identificação')
               ->schema([
                  TextEntry::make('user.name')
                     ->label('Nome Completo'),

                  TextEntry::make('user.email')
                     ->label('Email')
                     ->copyable()
                     ->copyMessage('Email copiado!')
                     ->url(fn($state) => "mailto:{$state}")
                     ->openUrlInNewTab(),

                  TextEntry::make('user.whatsapp')
                     ->label('WhatsApp')
                     ->copyable()
                     ->copyMessage('WhatsApp copiado!')
                     ->formatStateUsing(function ($state) {
                        if (!$state) return 'Não informado';

                        $cleaned = preg_replace('/\D/', '', $state);

                        if ((strlen($cleaned) === 13 || strlen($cleaned) === 12) && str_starts_with($cleaned, '55')) {
                           $cleaned = substr($cleaned, 2);
                        }

                        if (strlen($cleaned) === 11) {
                           return preg_replace('/(\d{2})(\d{1})(\d{4})(\d{4})/', '($1) $2$3-$4', $cleaned);
                        } elseif (strlen($cleaned) === 10) {
                           return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $cleaned);
                        }

                        return $cleaned;
                     })
                     ->copyableState(fn($record) => preg_replace('/\D/', '', $record->user->whatsapp))
                     ->url(fn($record) => $record->user->whatsapp ? "https://wa.me/" . preg_replace('/\D/', '', $record->user->whatsapp) : null)
                     ->openUrlInNewTab(),
               ])
               ->collapsible()
               ->persistCollapsed()
               ->columns(2),

            Section::make('Informações Financeiras')
               ->description('Detalhes sobre despesas e valores do apadrinhamento')
               ->schema([
                  Group::make()
                     ->schema([
                        TextEntry::make('expense.type')
                           ->label('Tipo de Despesa'),

                        TextEntry::make('expense.amount')
                           ->label('Valor da Despesa')
                           ->money('BRL'),
                     ])
                     ->columns(2),

                  Group::make()
                     ->schema([
                        TextEntry::make('expense.recurrence_days')
                           ->label('Recorrência')
                           ->suffix(' dias')
                           ->placeholder('Único')
                           ->color('secondary'),

                        TextEntry::make('amount')
                           ->label('Valor do Apadrinhamento')
                           ->money('BRL'),
                     ])
                     ->columns(2),
               ])
               ->collapsible()
               ->persistCollapsed()
               ->columns(1),

            Section::make('Histórico')
               ->description('Datas de criação e última atualização')
               ->schema([
                  TextEntry::make('created_at')
                     ->label('Criado em')
                     ->since()
                     ->dateTimeTooltip(),

                  TextEntry::make('updated_at')
                     ->label('Última atualização')
                     ->since()
                     ->dateTimeTooltip(),
               ])
               ->collapsible()
               ->persistCollapsed()
               ->columns(2),
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
