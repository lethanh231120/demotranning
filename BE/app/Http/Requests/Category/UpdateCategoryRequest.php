<?php

namespace App\Http\Requests\Category;

use App\Rules\Category\ValidateParentId;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'parent_id' => [
                'nullable', 'max:50',
                new ValidateParentId(),
                ($this -> parent_id == config('constants.PARENT_ID') ? '' : 'exists:categories,id')
            ],
        ];
    }

    /**
     * display messenger when users enter incorrectly.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => ':attribute không được để trống',
            'max' => ':attribute không được lớn hơn :max kí tự',
            'exists' => ':attribute không tồn tại',
        ];
    }
}

