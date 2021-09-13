<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
class CreateProductRequest extends FormRequest
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
            'exprired_at' => 'required|after:'. Carbon::now(),
            'sku' =>  'required|min:10|max:20|regex:/(^([a-zA-Z0-9]+)$)/|unique:products',
            'category_id' => 'required|exists:categories,id',
            'avatar' => 'required|max:3072|mimes:jpeg,jpg,png',
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
            'name.required' => 'Bạn chưa nhập tên product ',
            'name.max' => 'Tên product không được quá 255 ký tự',
            'stock.required'=>'Bạn chưa nhập trường stock',
            'stock.min'=>'Trường stock không được nhỏ hơn 0',
            'stock.max'=>'Trường stock không được lớn hơn 10000',
            'stock.integer' =>'Trường stock bắt buộc phải là số',
            'exprired_at.required' => 'Trường exprired_at bắt buộc',
            'exprired_at.after'=>'exprired_at phải lớn hơn thời điểm hiện tại',
            'sku.required' =>'Trường sku bắt buộc phải nhập',
            'sku.min'=>'Trường sku không được nhỏ hơn 10 ký tự',
            'sku.max'=>'Trường sku không được lớn hơn 20 ký tự',
            'sku.regex'=>'Trường sku phải chưa các ký tự A-Z, a-z, 0-9',
            'sku.unique'=>'Đã tồn tại trường sku',
            'category_id.required'=>' Bạn chưa nhập trường category_id',
            'category_id.exists' =>'Trường category_id phải tồn tại trong database',
            'avatar.required'=>'Bạn chưa chọn avatar',
            'avatar.max'=>'Dụng lượng tối đa cho một ảnh là 3MB',
            'avatar.mimes'=>'Định dạng ảnh là jpg, png, jpeg',
            'price.required' => ' Bạn chưa nhập giá sản phẩm',
        ];
    }
}
