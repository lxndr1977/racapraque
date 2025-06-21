<?php

namespace App\Models\Animal;

use Carbon\Carbon;
use Spatie\Image\Enums\Fit;
use App\Casts\TemperamentCast;
use App\Enums\Animal\SizeEnum;
use App\Enums\Animal\GenderEnum;
use App\Enums\Animal\SpecieEnum;
use App\Enums\Animal\StatusEnum;
use Spatie\MediaLibrary\HasMedia;
use App\Casts\HealthConditionCast;
use Illuminate\Support\Facades\DB;
use App\Enums\Animal\SociabilityEnum;
use App\Enums\Animal\TemperamentEnum;
use App\Enums\Animal\ExpenseStatusEnum;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Animal\HealthConditionEnum;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Animal extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'gender',
        'size',
        'specie',
        'intake_date',
        'birth_date',
        'short_description',
        'full_description',
        'sociable_with_cats',
        'sociable_with_dogs',
        'sociable_with_children',
        'temperaments',  
        'special_needs',
        'health_conditions',
        'is_neutered',
        'notes',
        'is_adoption_ready',
        'is_visible_on_site',
        'status',
        'location_id',
        'location_identification',
        'animal_images',
    ];

    protected $casts = [
        'gender' => GenderEnum::class, 
        'size' => SizeEnum::class,
        'specie' => SpecieEnum::class,
        'sociable_with_cats' => SociabilityEnum::class,
        'sociable_with_dogs' => SociabilityEnum::class,
        'sociable_with_children' => SociabilityEnum::class,
        'temperaments' => 'array',
        'health_conditions' => 'array', 
        'special_needs' => 'array',
        'status' => StatusEnum::class,
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'animal_id', 'id');
    }

    public function sponsorships(): HasManyThrough
    {
        return $this->hasManyThrough(
            Sponsorship::class, 
            Expense::class,           
            'animal_id',              
            'expense_id',             
            'id',                     
            'id'                      
        );
    }

    public function scopeActives(Builder $query): void
    {
        $query->where([
            ['status', StatusEnum::Active],
            ['is_visible_on_site', true]
        ]);
    }

    public function scopeAdoptables(Builder $query): void
    {
        $query->where([
            ['is_adoption_ready', true],
            ['status', StatusEnum::Active],
            ['is_visible_on_site', true]
        ]);
    }

    public function scopeSponsorables(Builder $query): void
    {
        $query->where('status', StatusEnum::Active)
            ->where('is_visible_on_site', true)
            ->whereHas('expenses', function ($q) {
                $q->active();
            });
    }

    public function expensesActive()
    {
        return $this->expenses()->active();
    }

    public function expensesInProgress()
    {
        return $this->expenses()->inProgress();
    }

    protected function specieLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->specie->getLabel()
        );
    }
    
    protected function genderLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->gender->getLabel()
        );
    }

    protected function genderedName(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->gender === GenderEnum::Male ? 'o ' : 'a ') . $this->name
        );
    }

    protected function sizeLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->size->getLabel()
        );
    }

    protected function sociableWithCatsLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->sociable_with_cats->getLabel()
        );
    }

    protected function sociableWithDogsLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->sociable_with_dogs->getLabel()
        );
    }

    protected function sociableWithChildrenLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->sociable_with_children->getLabel()
        );
    }

    protected function temperamentLabels(): Attribute
    {
        return Attribute::make(
            get: fn () => collect($this->temperaments ?? [])
                ->map(fn($value) => TemperamentEnum::tryFrom($value)?->getLabel())
                ->filter()
                ->implode(', ')
        );
    }

    protected function healthConditionsLabels(): Attribute
    {
        return Attribute::make(
            get: fn () => collect($this->health_conditions ?? [])
                ->map(fn($value) => HealthConditionEnum::tryFrom($value)?->getLabel())
                ->filter()
                ->implode(', ')
        );
    }

    protected function neuteredStatus(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->is_neutered ? 'Sim' : 'Não'
        );
    }

    protected function age(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->birth_date 
                ? Carbon::parse($this->birth_date)->age . ' anos' 
                : 'Não informado'
        );
    }

    protected function intakeYear(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->intake_date 
                ? Carbon::parse($this->intake_date)->year 
                : 'Não informado'
        );
    }
    
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('responsive')
            ->fit(Fit::Crop, 1280, 1280)
            ->format('webp')
            ->withResponsiveImages()
            ->nonQueued();

        $this->addMediaConversion('thumbnail')
            ->fit(Fit::Crop, 50, 50)
            ->format('webp')
            ->nonQueued();
    }


    // No model Animal.php
protected function locationName(): Attribute
{
    return Attribute::make(
        get: fn () => $this->location?->name ?? 'Localização não informada'
    );
}
}
