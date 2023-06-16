<?php

namespace Dcodegroup\PageBuilder\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FolderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'parent_id' => 'nullable|exists:folders,id',
        ];
    }
}
