<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
            'tech_stack' => 'required|array',
            'link_demo' => 'nullable|url',
            'link_github' => 'nullable|url',
        ];
    }
}