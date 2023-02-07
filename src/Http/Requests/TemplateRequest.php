<?php

namespace Dcodegroup\PageBuilder\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TemplateRequest extends FormRequest
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
                    'name' => 'required|max:255',
                    'key' => [
                        'required',
                        'max:255',
                        Rule::unique('templates', 'key')
                            ->ignore($this->route('template')->id ?? null),
                    ],
                ];
        }
    }
}
