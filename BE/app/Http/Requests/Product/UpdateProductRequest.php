<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'stock' => 'required|min:0|max:10000|integer',
            'exprired_at' => 'required',
            'sku' =>  'required|min:10|max:20|regex:/(^([a-zA-Z0-9]+)$)/|unique:products,sku,'. $this ->id,
            'category_id' => 'required|exists:categories,id',
            'avatar' => (empty($this -> avatar_path) ? 'required|':'').'max:3072|mimes:jpeg,jpg,png',
            'flag_delete' => 'in:0,1',
            'price' => 'required',
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
            'integer' => ':attribute phải là số',
            'max' => ':attribute không được lớn hơn :max kí tự',
            'min' => ':attribute không được nhỏ hơn :min kí tự',
            'exists' => ':attribute không tồn tại',
            'mimes' => ':attribute phải có định dạng :mimes',
            'unique' => ':attribute đã tồn tại',
            'regex' => ':attribute phải chứa các kí tự A-Z, a-z, 0-9',
            'in' => ':atribute nhận giá trị :in',
            'price.required' => ' Bạn chưa nhập giá sản phẩm',
        ];
    }
}

