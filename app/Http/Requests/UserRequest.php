<?php

namespace App\Http\Requests;

class UserRequest extends Request
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
                    'first_name' => [
                        'required',
                        'string',
                    ],
                    'last_name' => [
                        'required',
                        'string',
                    ],
                    'email' => [
                        'required',
                        'email',
                    ],
                    'password' => [
                        'required',
                        'string',
                        'min:8'
                    ],
                ];
            case 'PATCH':
                return [
                    'first_name' => [
                        'sometimes',
                        'required',
                        'string',
                    ],
                    'last_name' => [
                        'sometimes',
                        'required',
                        'string'
                    ],
                    'email' => [
                        'sometimes',
                        'required',
                        'email'
                    ],
                    'password' => [
                        'sometimes',
                        'required',
                        'string',
                        'min:8'
                    ]
                ];
            default:
                return [];
        }
    }
}
