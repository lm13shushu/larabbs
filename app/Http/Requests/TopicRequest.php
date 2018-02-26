<?php

namespace App\Http\Requests;
//代码生成器已经为我们生成了 TopicRequest 表单验证类，并且自动在控制器方法中注入
class TopicRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            //表单方法 POST, PUT, PATCH 使用的是相同的一套验证规则
            case 'POST':
            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    // UPDATE ROLES
                'title'       => 'required|min:2',
                'body'        => 'required|min:3',
                'category_id' => 'required|numeric',
                ];
            }
            case 'GET':
            case 'DELETE':
            default:
            {
                return [];
            };
        }
    }

    public function messages()
    {
        return [
            // Validation messages
            'title.min' => '标题必须至少两个字符',
            'body.min' => '文章内容必须至少三个字符',
        ];
    }
}
