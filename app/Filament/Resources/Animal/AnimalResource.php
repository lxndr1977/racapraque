<?php

namespace App\Filament\Resources\Animal;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\Animal\Animal;
use App\Enums\Animal\SizeEnum;
use App\Enums\Animal\GenderEnum;
use App\Enums\Animal\SpecieEnum;
use App\Enums\Animal\StatusEnum;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Enums\Animal\SociabilityEnum;
use App\Enums\Animal\TemperamentEnum;
use App\Enums\Animal\HealthConditionEnum;
use App\Enums\Animal\LocationTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Animal\AnimalResource\Pages;
use App\Filament\Resources\Animal\AnimalResource\RelationManagers;
use BladeUI\Icons\Components\Icon;

class AnimalResource extends Resource
{
    protected static ?string $model = Animal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Animal';

    protected static ?string $pluralModelLabel = 'Animais';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações do animal')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->columnSpan(2)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state, string $operation) {
                                if (($get('slug') ?? '') !== Str::slug($old) || $operation === 'edit') {
                                    return;
                                }
        
                                $set('slug', Str::slug($state));
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->columnSpan(2)
                            ->unique(ignoreRecord: true)
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options(StatusEnum::class)
                            ->required(),
                        Forms\Components\Select::make('specie')
                            ->label('Espécie')
                            ->options(SpecieEnum::class)
                            ->required(),                            
                        Forms\Components\Select::make('gender')
                            ->label('Sexo')
                            ->options(GenderEnum::class)
                            ->required(),
                        Forms\Components\Select::make('size')
                            ->label('Porte')
                            ->options(SizeEnum::class)
                            ->required(),
                        Forms\Components\DatePicker::make('birth_date')
                            ->label('Nascimento'),
                        Forms\Components\DatePicker::make('intake_date')
                            ->label('Entrada'),
                        Forms\Components\Select::make('location_id')
                            ->label('Local')   
                            ->relationship('location', 'name') 
                            ->required()
                            ->preload()
                            ->searchable(),
                        Forms\Components\TextInput::make('location_identification')
                            ->label('Identificação do local'),
                        Forms\Components\Toggle::make('is_visible_on_site')
                            ->label('Exibir no site')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(4),

                Forms\Components\Section::make('Detalhes')
                    ->schema([
                        Forms\Components\Select::make('sociable_with_cats')
                            ->label('Sociável com gatos')
                            ->options(SociabilityEnum::class)
                            ->required(),
                        Forms\Components\Select::make('sociable_with_dogs')
                            ->label('Sociável com cachorros')
                            ->options(SociabilityEnum::class)
                            ->required(),
                        Forms\Components\Select::make('sociable_with_children')
                            ->label('Sociável com crianças')
                            ->options(SociabilityEnum::class)
                            ->required(),
                        Forms\Components\Select::make('temperaments')
                            ->label('Temperamento')
                            ->columnSpanFull()
                            ->options(TemperamentEnum::class)
                            ->multiple() 
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('health_conditions')
                            ->label('Condições de saúde')
                            ->columnSpanFull()
                            ->options(HealthConditionEnum::class)
                            ->multiple() 
                            ->searchable()
                            ->preload(),
                        Forms\Components\TagsInput::make('special_needs')
                            ->label('Necessidades especiais')
                            ->columnSpanFull()
                            ->placeholder('Nova necessidade')
                            ->separator(', '),
                        Forms\Components\Toggle::make('is_neutered')
                            ->label('Castrado')
                            ->required(),                
                        Forms\Components\Toggle::make('is_adoption_ready')
                            ->label('Apto para adoção')
                            ->required(),
            
                    ])
                    ->columns(3),
                    
                Forms\Components\Section::make('Fotos')
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('animal_images')
                            ->multiple()
                            ->reorderable()
                            ->responsiveImages()
                            ->conversion('thumbnail')
                            ->conversion('responsive')
                            ->panelLayout('grid')
                            ->collection('animals')
                            ->appendFiles()
                    ]),
                
                Forms\Components\Section::make('Descrição do animal')
                    ->schema([
                        Forms\Components\Textarea::make('short_description')
                            ->label('Descrição curta')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('full_description')
                            ->label('Descrição completa')
                            ->columnSpanFull()
                            ->rows(10),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Anotações')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label('Anotações (uso interno)')
                            ->columnSpanFull()
                            ->rows(10),
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
                Tables\Columns\TextColumn::make('specie')
                        ->label('Espécie'),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Sexo'),
                Tables\Columns\TextColumn::make('size')
                    ->label('Porte'),
                Tables\Columns\TextColumn::make('location.is_volunteer')
                    ->label('Local')
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge(),                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('specie')
                    ->label('Espécie')
                    ->options(SpecieEnum::class),                
                Tables\Filters\SelectFilter::make('gender')
                    ->label('Sexo')
                    ->options(GenderEnum::class),                    
                Tables\Filters\SelectFilter::make('size')
                    ->label('Porte')
                    ->options(SizeEnum::class),                    
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options(StatusEnum::class)
                    ->default(StatusEnum::Active->value),
                Tables\Filters\SelectFilter::make('location.is_volunterr')
                    ->label('Local')
                    ->options(LocationTypeEnum::class)                    
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
                Section::make('Informações do animal')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nome')
                            ->columnSpan(2),
                        TextEntry::make('slug')
                            ->label('Slug')
                            ->columnSpan(2),
                        TextEntry::make('status')
                            ->label('Status'),
                        TextEntry::make('specie')
                            ->label('Espécie'),                            
                        TextEntry::make('gender')
                            ->label('Sexo'),
                        TextEntry::make('size')
                            ->label('Porte'),
                        TextEntry::make('birth_date')
                            ->label('Nascimento'),
                        TextEntry::make('intake_date')
                            ->label('Entrada'),
                        TextEntry::make('location.name')
                            ->label('Local'),
                        TextEntry::make('location_identification')
                            ->label('Identificação do local'),
                        IconEntry::make('is_visible_on_site')
                            ->label('Exibir no site')
                            ->boolean(),
                    ])
                    ->columns(4),

                Section::make('Detalhes')
                    ->schema([
                        TextEntry::make('sociable_with_cats')
                            ->label('Sociável com gatos'),
                        TextEntry::make('sociable_with_dogs')
                            ->label('Sociável com cachorros'),
                        TextEntry::make('sociable_with_children')
                            ->label('Sociável com crianças'),
                        TextEntry::make('temperaments')
                            ->label('Temperamento')
                            ->getStateUsing(fn($record) => $record->temperamentLabels) 
                            ->columnSpanFull(),
                        TextEntry::make('health_conditions')
                            ->label('Condições de saúde')
                            ->getStateUsing(fn($record) => $record->healthConditionsLabels) 
                            ->columnSpanFull(),
                        TextEntry::make('special_needs')
                            ->label('Necessidades especiais')
                            ->columnSpanFull(),
                        IconEntry::make('is_neutered')
                            ->label('Castrado')
                            ->boolean(),                
                        IconEntry::make('is_adoption_ready')
                            ->label('Apto para adoção')
                            ->boolean()
                    ])
                    ->columns(4),


                Section::make('Descrição')
                    ->schema([
                        TextEntry::make('short_description')
                            ->label('Descrição curta'),
                        TextEntry::make('full_description')
                            ->label('Descrição completa'),
                    ]),

                Section::make('Anotações')
                    ->schema([  
                        TextEntry::make('notes')
                            ->label('Anotações de uso interno')
                    ])
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\ExpenseRelationManager::class,
            RelationManagers\SponsorshipsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnimals::route('/'),
            'create' => Pages\CreateAnimal::route('/create'),
            'view' => Pages\ViewAnimal::route('/{record}'),
            'edit' => Pages\EditAnimal::route('/{record}/edit'),
        ];
    }
}
