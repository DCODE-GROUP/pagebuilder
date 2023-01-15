<?php

namespace Dcodegroup\PageBuilder\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
            case 'PUT':
            case 'PATCH':
                return [
                    'title' => 'sometimes|required|max:255',
                    'slug' => [
                        'sometimes',
                        'required',
                        'max:255',
                        Rule::unique('pages', 'slug')->ignore($this->route('page')->id ?? null),
                    ],
                    'template_id' => 'nullable|exists:templates,id',
                    'abstract' => 'nullable|max:65535',
                    'content' => 'nullable|json',
                    'dynamic_content' => 'nullable|json',
                ];
                break;
        }
    }
}
