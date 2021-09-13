<?php

namespace App\Http\Requests\Admin;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Laravel\Fortify\Rules\Password;

class UpdateUserRequest extends FormRequest
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
        $year_old = Carbon::now()->subYears(18);
        return [
            'email' => 'required|email|max:100|unique:users,email,' . $this->id,
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'birthday' => 'required|before:' . (string)$year_old,
            'user_name' =>  'required|max:100|unique:users,user_name,' . $this->id,
            'flag_delete' => 'in:0,1',
            'status' => 'required|string',
            'avatar' => (empty($this->avatar_path) ?: '') . 'max:3072|mimes:jpeg,jpg,png',
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
            'user_name.required' => 'Bạn phải nhập tên user_name',
            'user_name.unique' => 'Tên đã tồn tại',
            'user_name.max' => 'User_name không được quá 100 ký tự',
            'email.email' => 'Bạn nhập sai định dạng của email',
            'email.required' => 'Email bắt buộc phải sửa',
            'email.unique' => 'Tên email đã tồn tại',
            'email.max' => 'Email không được quá 100 ký tự',
            'first_name.required' => 'Bạn chưa nhập first_name',
            'first_name.max' => 'First_name không được quá 50 ký tự',
            'last_name.required' => 'Bạn chưa nhập last_name',
            'last_name.max' => 'Last_name không được quá 50 ký tự',
            'birthday.required' => 'Bạn chưa nhập birthday',
            'birthday.before' => 'Tuổi phải trên 18 tuổi',
            'status.required' => 'Bạn chưa nhập trường status',
            'status.string' => 'Trường status chỉ nhận dạng chuỗi',
            'password.required' => 'Bạn chưa nhập trường password',
            'password.string' => 'password phải là dạng chuỗi',
            'avatar.mimes' => ':attribute chỉ nhận định dạng png,jpeg,jpg',
            'avatar.max' => 'Kích thước ảnh không được quá 3MB',
            'flag_delete.in' => "Trường flag_delete có giá trị là 0 hoặc 1"
        ];
    }
}
