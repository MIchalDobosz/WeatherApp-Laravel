<?php

namespace App\Rules;

use App\Models\City;
use Illuminate\Contracts\Validation\Rule;

class CityAlreadyExists implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return City::where('name', $value)->first() == null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Miasto już na liście';
    }
}
