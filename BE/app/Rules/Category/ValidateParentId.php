<?php

namespace App\Rules\Category;

use App\Models\Category;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ValidateParentId implements Rule
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
        if ($value == config('constants.PARENT_ID')) {
            return true;
        } else {
            // get user information login
            $user = Auth::guard('web') -> user();
            // get list parent category
            $parent = Category::select('id')
                -> where('user_id', $user -> id)
                -> where('parent_id', config('constants.PARENT_ID'))
                -> where('flag_delete', config('constants.FLAG_DELETE'))
                -> get();
            foreach ($parent as $item) {
                if ($item -> id == $value) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute không hợp lệ!';
    }
}
