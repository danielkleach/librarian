<?php

namespace App\Http\Requests;

class AuthorRequest extends Request
{
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => [
                        'required',
                        'string',
                    ]
                ];
            case 'PATCH':
                return [
                    'name' => [
                        'sometimes',
                        'required',
                        'string',
                    ]
                ];
            default:
                return [];
        }
    }
}
