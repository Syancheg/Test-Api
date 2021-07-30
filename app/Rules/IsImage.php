<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Services\ImageService;

class IsImage implements Rule
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
        if(filter_var($value, FILTER_VALIDATE_URL) !== false){
            $ext = pathinfo($value, PATHINFO_EXTENSION);
            if($ext != 'png' && $ext != 'jpeg' && $ext != 'jpg'){
                return false;
            } else {
                $imageService = new ImageService;
                return $imageService->saveImageToStorage($value);
            }
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Images of the jpg, jpeg, png format are accepted by the link, no more than 2 MB in size.';
    }
}
