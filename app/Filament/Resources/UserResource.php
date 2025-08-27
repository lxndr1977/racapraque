<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\User\RoleEnum;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Infolists\Components\Group;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
   protected static ?string $model = User::class;

   protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

   protected static ?string $modelLabel = 'Usuário';

   protected static ?string $pluralModelLabel = 'Usuários';

   public static function form(Form $form): Form
   {
      return $form
         ->schema([
            Forms\Components\Section::make('Informações do usuário')
               ->schema([
                  Forms\Components\TextInput::make('name')
                     ->required()
                     ->label('Nome'),

                  Forms\Components\TextInput::make('whatsapp')
                     ->required()
                     ->label('WhatsApp')
                     ->placeholder('51987654321 ou 5132769038')
                     ->maxLength(15)
                     ->dehydrateStateUsing(
                        fn(?string $state): ?string =>
                        $state ? preg_replace('/\D/', '', $state) : null
                     )
                     ->formatStateUsing(function (?string $state): ?string {
                        if (!$state) return null;

                        $cleaned = preg_replace('/\D/', '', $state);

                        if (strlen($cleaned) === 11) {
                           return preg_replace('/(\d{2})(\d{1})(\d{4})(\d{4})/', '($1) $2$3-$4', $cleaned);
                        } elseif (strlen($cleaned) === 10) {
                           return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $cleaned);
                        }

                        return $cleaned;
                     })
                     ->live()
                     ->afterStateUpdated(function (Forms\Set $set, ?string $state) {
                        if (!$state) return;

                        $cleaned = preg_replace('/\D/', '', $state);

                        if (strlen($cleaned) === 12) {
                           $formatted = preg_replace('/(\d{2})(\d{1})(\d{4})(\d{4})/', '($1) $2$3-$4', $cleaned);
                           $set('whatsapp', $formatted);
                        } elseif (strlen($cleaned) === 10) {
                           $formatted = preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $cleaned);
                           $set('whatsapp', $formatted);
                        }
                     }),

                  Forms\Components\TextInput::make('email')
                     ->label('Email')
                     ->email()
                     ->required()
                     ->unique(ignoreRecord: true),

                  Forms\Components\TextInput::make('password')
                     ->label('Senha')
                     ->password()
                     ->required(fn(string $operation): bool => $operation === 'create')
                     ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                     ->dehydrated(fn(?string $state): bool => filled($state)),

                  Forms\Components\Select::make('role')
                     ->label('Permissão')
                     ->options(RoleEnum::class)
                     ->required(),
               ])
               ->columns(2)
         ]);
   }

   public static function table(Table $table): Table
   {
      return $table
         ->columns([
            Tables\Columns\TextColumn::make('name')
               ->label('Nome')
               ->sortable()
               ->searchable(),

            Tables\Columns\TextColumn::make('email')
               ->label('Email')
               ->searchable(),

            Tables\Columns\TextColumn::make('role')
               ->label('Permissão')
               ->searchable(),

            Tables\Columns\TextColumn::make('email_verified_at')
               ->label('Verificado em')
               ->dateTime()
               ->sortable()
               ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('created_at')
               ->label('Criado em')
               ->dateTime()
               ->sortable()
               ->toggleable(isToggledHiddenByDefault: true),
               
            Tables\Columns\TextColumn::make('updated_at')
               ->label('Atualizado em')
               ->dateTime()
               ->sortable()
               ->toggleable(isToggledHiddenByDefault: true),
         ])
         ->filters([
            Tables\Filters\SelectFilter::make('role')
               ->options(RoleEnum::class)
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
            Section::make('Dados Pessoais')
                ->description('Informações básicas do usuário')
                ->schema([
                    TextEntry::make('name')
                        ->label('Nome Completo')
                        ->columnSpanFull(),
                    
                    Group::make()
                        ->schema([
                            TextEntry::make('email')
                                ->label('Email')
                                ->copyable()
                                ->copyMessage('Email copiado!')
                                ->url(fn ($state) => "mailto:{$state}")
                                ->openUrlInNewTab(),
                            
                            TextEntry::make('whatsapp')
                                ->label('WhatsApp')
                                ->copyable()
                                ->copyMessage('WhatsApp copiado!')
                                ->copyableState(fn ($record) => preg_replace('/\D/', '', $record->whatsapp))
                                ->url(fn ($record) => $record->whatsapp ? "https://wa.me/55" . preg_replace('/\D/', '', $record->whatsapp) : null)
                                ->openUrlInNewTab()
                                ->placeholder('Não informado'),
                        ])
                        ->columns(2),
                ])
                ->collapsible()
                ->persistCollapsed()
                ->columns(1),

            Section::make('Sistema')
                ->description('Configurações de acesso e permissões')
                ->schema([
                    TextEntry::make('role')
                        ->label('Nível de Permissão')
                        ->columnSpanFull(),
                ])
                ->collapsible()
                ->persistCollapsed()
                ->columns(1),

            Section::make('Histórico')
                ->description('Datas de criação e última atualização')
                ->schema([
                    TextEntry::make('created_at')
                        ->label('Conta criada em')
                        ->since()
                        ->dateTimeTooltip(),
                    
                    TextEntry::make('updated_at')
                        ->label('Última atualização')
                        ->since()
                        ->dateTimeTooltip(),
                ])
                ->collapsible()
                ->collapsed()
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
         'index' => Pages\ListUsers::route('/'),
         'create' => Pages\CreateUser::route('/create'),
         'view' => Pages\ViewUser::route('/{record}'),
         'edit' => Pages\EditUser::route('/{record}/edit'),
      ];
   }
}
