<?php

namespace App\Casts;

use App\Enums\Animal\TemperamentEnum;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class TemperamentCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (empty($value)) {
            return [];
        }

        $value = json_decode($value, true);
        $value = is_array($value) ? $value : [];
        
        return array_map(
            fn($item) => TemperamentEnum::tryFrom($item)?->getLabel() ?? $item,
            $value
        ); 
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (is_array($value)) {
            return json_encode(array_filter($value, fn($item) => TemperamentEnum::tryFrom($item) !== null));
        }

        return json_encode([]);   
    }
}
