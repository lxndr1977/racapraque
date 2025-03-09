<?php

namespace App\Filament\Resources\Animal;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Animal\Animal;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Models\Animal\AdoptionRequest;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Animal\AdoptionRequestResource\Pages;
use App\Filament\Resources\Animal\AdoptionRequestResource\RelationManagers;
use Filament\Infolists\Components\IconEntry;

class AdoptionRequestResource extends Resource
{
    protected static ?string $model = AdoptionRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Solicitação de adoção';

    protected static ?string $pluralModelLabel = 'Solicitações de adoção';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações da solicitação de adoção')
                ->schema([
                    Forms\Components\Select::make('animal_id')
                        ->relationship('animal', 'name')
                        ->searchable()
                        ->preload()    
                        ->required(),
                    Forms\Components\TextInput::make('name')
                        ->label('Nome')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->maxLength(255)
                        ->default(null),
                    Forms\Components\TextInput::make('whatsapp')
                        ->label('Whatsapp')
                        ->maxLength(255)
                        ->default(null),
                    Forms\Components\Toggle::make('contacted')
                        ->label('Contatado')
                        ->required(),
                ])
                ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('animal.name')
                    ->label('Abrigado')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('whatsapp')
                    ->label('Whatsapp')
                    ->searchable(),
                Tables\Columns\IconColumn::make('contacted')
                    ->label('Contatado')
                    ->boolean(),
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
                Section::make('Informações do usuário')
                    ->schema([
                        TextEntry::make('animal.name')
                            ->label('Abrigado'),
                        TextEntry::make('name')
                            ->label('Nome'),
                        TextEntry::make('email')
                            ->label('Email'),                            
                        TextEntry::make('whatsapp')
                            ->label('Whatsapp'),
                        IconEntry::make('contacted')
                            ->label('Contatado')
                            ->boolean(),
                        TextEntry::make('created_at')
                            ->label('Criado em')
                            ->since(),                            
                        TextEntry::make('updated_at')
                            ->label('Atualizado em')
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
            'index' => Pages\ListAdoptionRequests::route('/'),
            'create' => Pages\CreateAdoptionRequest::route('/create'),
            'view' => Pages\ViewAdoptionRequest::route('/{record}'),
            'edit' => Pages\EditAdoptionRequest::route('/{record}/edit'),
        ];
    }
}
