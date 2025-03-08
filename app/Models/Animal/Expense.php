<?php

namespace App\Models\Animal;

use App\Enums\Animal\ExpenseTypeEnum;
use App\Enums\Animal\ExpenseStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\Animal\ExpenseRecurrenceEnum;
use App\Enums\Animal\ExpenseTimeStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'description',
        'amount',
        'start_date',
        'end_date',
        'recurrence_days',
        'payment_links',
        'total_sponsorship',
        'payment_link',
        'animal_id',
    ];

    protected $casts = [
        'recurrence_days' => ExpenseRecurrenceEnum::class,
        'type' => ExpenseTypeEnum::class,
        'status' => ExpenseStatusEnum::class,
        'payment_links' => 'array',
    ];

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }

    public function sponsorships(): HasMany
    {
        return $this->hasMany(Sponsorship::class, 'expense_id', 'id');
    }


    protected function status(): Attribute
    {
        return Attribute::get(function () {
            if (is_null($this->start_date) && is_null($this->end_date)) {
                return $this->total_sponsorship >= $this->amount 
                    ? ExpenseStatusEnum::Sponsored 
                    : ExpenseStatusEnum::Active;
            }
    
            if ($this->start_date > now()) {
                return ExpenseStatusEnum::NotStarted;
            }
    
            if ($this->total_sponsorship >= $this->amount) {
                return ExpenseStatusEnum::Sponsored;
            }
    
            if ($this->end_date <= now()) {
                return ExpenseStatusEnum::ClosedWithoutSponsorship; 
            }
    
            return ExpenseStatusEnum::Active;
        });
    }
    
    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status->getLabel()
        );
    }

    protected function timeStatus(): Attribute
    {
        return Attribute::get(function () {
            if (is_null($this->start_date) && is_null($this->end_date)) {
                return ExpenseTimeStatusEnum::InProgress; 
            }
        
            $startDate = !is_null($this->start_date) ? \Carbon\Carbon::parse($this->start_date)->toDateString() : null;
            $endDate = !is_null($this->end_date) ? \Carbon\Carbon::parse($this->end_date)->toDateString() : null;
            $today = today()->toDateString();
        
            if (!is_null($startDate) && $startDate > $today) {
                return ExpenseTimeStatusEnum::NotStarted;
            }
        
            if (!is_null($endDate) && $endDate < $today) {
                return ExpenseTimeStatusEnum::Closed;
            }
        
            return ExpenseTimeStatusEnum::InProgress;
        });       
    }

    protected function scopeActive(Builder $query)
    {
        $query->where(function ($query) {
            $query->whereNull('start_date')
                  ->whereNull('end_date')
                  ->whereRaw('total_sponsorship < amount');
        })
        ->orWhere(function ($query) {
            $query->where('start_date', '<=', now())
                  ->where('end_date', '>=', now())
                  ->whereRaw('total_sponsorship < amount');
        });
    }

    protected function scopeInProgress(Builder $query)
    {
        $query->where(function ($query) {
            $query->whereNull('start_date')
                  ->whereNull('end_date');
        })
        ->orWhere(function ($query) {
            $query->where('start_date', '<=', now())
                  ->where('end_date', '>=', now());
        });
    }

    protected function recurrenceDaysLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->recurrence_days->getLabel()
        );
    }

    protected function typeLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->type->getLabel()
        );
    }

    protected function formattedAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => 'R$ ' . number_format($this->amount, 2, ',', '.')
        );
    }
}
