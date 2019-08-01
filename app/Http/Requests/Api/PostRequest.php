<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string',
            'topic_name' => 'string',
            'image' => 'mimes:jpeg,bmp,png,gif',
        ];
    }

    public function attributes()
    {
        return [
            'title' => '内容',
            'topic_name' => '话题',
            'image' => '图片',
        ];
    }
}
