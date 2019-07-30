<?php

namespace App\Http\Requests\Api;

class UserRequest extends FormRequest
{
    public function rules()
    {
        switch($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|between:3,25|unique:admin_users,name',
                    'password' => 'required|string|min:6',
                    'verification_key' => 'required|string',
                    'verification_code' => 'required|string',
                ];
                break;
            case 'PATCH':
                $userId = \Auth::guard('api')->id();

                return [
                    'name' => 'between:3,25|unique:admin_users,name,' .$userId,
                    'email' => 'email|unique:admin_users,email,' .$userId,
                    'introduction' => 'max:80',
                    'dice_id' => 'min:1',
                    'avatar_image_id' => 'exists:images,id,type,avatar,user_id,'.$userId,
                ];
                break;
        }
    }

    public function attributes()
    {
        return [
            'verification_key' => '短信验证码 key',
            'verification_code' => '短信验证码',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => '用户名已被占用，请重新填写',
            'name.between' => '用户名必须介于 3 - 25 个字符之间。',
            'name.required' => '用户名不能为空。',
            'email.unique' => '邮箱已被绑定。',
            'dice_id.min' => '更改花名机会已用完',
        ];
    }
}