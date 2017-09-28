<?php

namespace App\Http\Requests;

class BookRequest extends Request
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
                    'owner_id' => [
                        'integer',
                        'exists:users,id',
                    ],
                    'title' => [
                        'sometimes',
                        'required',
                        'string',
                    ],
                    'description' => [
                        'sometimes',
                        'required',
                        'string',
                    ],
                    'isbn' => [
                        'sometimes',
                        'required',
                        'string',
                    ],
                    'publication_year' => [
                        'sometimes',
                        'required',
                        'numeric',
                    ],
                    'location' => [
                        'required',
                        'string',
                    ],
                    'cover_image_url' => [
                        'string'
                    ]
                ];
            case 'PATCH':
                return [
                    'owner_id' => [
                        'sometimes',
                        'required',
                        'integer',
                        'exists:users,id',
                    ],
                    'title' => [
                        'sometimes',
                        'required',
                        'string',
                    ],
                    'description' => [
                        'sometimes',
                        'required',
                        'string',
                    ],
                    'isbn' => [
                        'sometimes',
                        'required',
                        'string',
                    ],
                    'publication_year' => [
                        'sometimes',
                        'required',
                        'numeric',
                    ],
                    'location' => [
                        'sometimes',
                        'required',
                        'string',
                    ],
                    'cover_image_url' => [
                        'string'
                    ]
                ];
            default:
                return [];
        }
    }
}
