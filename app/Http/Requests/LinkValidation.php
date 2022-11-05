<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinkValidation extends FormRequest
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
        $uniqueCode = '|unique:short_link';

        if ($this->route('id')) {
            $uniqueCode .= ',id,'.$this->route('id');
        }
        return [
            'url'  => 'required',
            'code' => 'max:20'.$uniqueCode,
            'expires_at' => 'date|after:now|nullable',
        ];
    }
}
