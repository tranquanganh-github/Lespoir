<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
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
            'username' => 'required|min:6|max:52',
            'password' => 'required|min:8|max:30',
            'config_password' => 'required|required_with:password|same:password',
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'leyka_donor_phone' => 'required|numeric',
            'data_phone' => 'required|numeric',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Tài khoản không được để trống',
            'username.min' => 'Tài khoản quá ngắn',
            'username.max' => 'Tài khoản quá dài',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu quá ngắn',
            'password.max' => 'mật khẩu quá dài',
            'config_password.required' => 'Xác nhận mật khẩu không được để trống',
            'config_password.required_with' => 'Mật khẩu không khớp',
            'config_password.same' => 'Mật khẩu không khớp',
            'name.required' => 'Tên không được để trống',
            'email.required' => 'Email không được để trống',
            'address.required' => 'Địa chỉ không được để trống',
            'leyka_donor_phone.required' => 'Số điện thoại không được để trống',
            'leyka_donor_phone.max' => 'Số điện thoại quá dài',
            'leyka_donor_phone.numeric' => 'Số điện thoại không hợp lệ',
            'data_phone.required' => 'Mã quốc gia không hợp lệ',
            'data_phone.numeric' => 'Mã quốc gia không hợp lệ',
        ];
    }

    public function withValidator($validator)
    {
        $regularPassword = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";
        $regularEmail = "/^[^@\s]+@[^@\s]+\.[^@\s]+$/";
        $regularFullName = "/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s\W|_]+/";
        $regularUsername = "/^[a-zA-Z0-9_.-]*$/";
        $validator->after(function ($validator) use($regularPassword,$regularEmail,$regularFullName,$regularUsername){
            if (preg_match($regularPassword, $this->get('password'))!=1) {
                $validator->errors()->add('password', 'Mật khẩu không đúng định dạng');
            }
            if (preg_match($regularEmail, $this->get('email'))!=1) {
                $validator->errors()->add('email', 'Email không đúng định dạng');
            }
            if (preg_match($regularFullName, $this->get('name'))!=1) {
                $validator->errors()->add('name', 'Tên họ không đúng định dạng');
            }
            if (preg_match($regularUsername, $this->get('username'))!=1) {
                $validator->errors()->add('username', 'tài khoản không đúng định dạng');
            }
        });

    }
}
