<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DropoffLocation;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DropoffLocationResource\Pages;
use App\Filament\Resources\DropoffLocationResource\RelationManagers;
use BladeUI\Icons\Components\Icon;
use Filament\Infolists\Components\IconEntry;

class DropoffLocationResource extends Resource
{
    protected static ?string $model = DropoffLocation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Ponto de Coleta';

    protected static ?string $pluralModelLabel = 'Pontos de Coleta';

    protected static ?string $slug = 'pontos-de-coleta';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações do local de abrigo')
                ->schema([ 
                    
                    Forms\Components\TextInput::make('name')
                        ->label('Nome')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('address')
                        ->label('Endereço')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('number')
                        ->label('Número')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('complement')
                        ->label('Complemento')
                        ->maxLength(255)
                        ->default(null),
                    Forms\Components\TextInput::make('city')
                        ->label('Cidade')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('neighborhood')
                        ->label('Bairro')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('state')
                        ->label('Estado')
                        ->required()
                        ->maxLength(2),
                    Forms\Components\TextInput::make('zip_code')
                        ->label('CEP')
                        ->required()
                        ->maxLength(9),
                    Forms\Components\TextInput::make('phone')
                        ->label('Telefone')
                        ->tel()
                        ->maxLength(255)
                        ->default(null),
                    Forms\Components\TextInput::make('whatsapp')
                        ->label('Whatsapp')
                        ->maxLength(255)
                        ->default(null),
                    Forms\Components\Toggle::make('accepts_only_plastic_caps')
                        ->label('Aceita somente tampinhas')
                        ->default(false),
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('Cidade')
                    ->searchable(),
                Tables\Columns\TextColumn::make('neighborhood')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('whatsapp')
                    ->label('Whatsapp')
                    ->searchable(),
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
                Section::make('Informações do local de abrigo')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nome'),
                        TextEntry::make('address')
                            ->label('Endereço'),
                        TextEntry::make('number')
                            ->label('Número'),
                        TextEntry::make('complement')
                            ->label('Complemento'),
                        TextEntry::make('city')
                            ->label('Cidade'),
                        TextEntry::make('state')
                            ->label('Estado'),
                        TextEntry::make('zip_code')
                            ->label('CEP'),
                        TextEntry::make('phone')
                            ->label('Telefone'), 
                        TextEntry::make('whatsapp')
                            ->label('Whatsapp'),                           
                        IconEntry::make('accepts_only_plastic_caps')
                            ->label('Aceita somente tampinhas')
                            ->boolean(),                        
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
            'index' => Pages\ListDropoffLocations::route('/'),
            'create' => Pages\CreateDropoffLocation::route('/create'),
            'view' => Pages\ViewDropoffLocation::route('/{record}'),
            'edit' => Pages\EditDropoffLocation::route('/{record}/edit'),
        ];
    }
}
