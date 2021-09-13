<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Category\ValidateParentId;

class CreateCategoryRequest extends FormRequest
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
    public function messages(){
        return[
            'name.required'=>'Bạn chưa nhập tên danh mục',
            'name.max'=>'Tên danh mục không được quá 255 ký tự',
            'parent_id.max'=>'Parent_id không được qua 50 ký tự',
            'parent_id.exists'=> 'parent_id không tồn tại',
        ];
    }
}
