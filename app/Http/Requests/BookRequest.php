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
                    'category_id' => [
                        'required',
                        'integer',
                        'exists:categories,id',
                    ],
                    'author_id' => [
                        'required',
                        'integer',
                        'exists:authors,id',
                    ],
                    'owner_id' => [
                        'required',
                        'integer',
                        'exists:users,id',
                    ],
                    'title' => [
                        'required',
                        'string',
                    ],
                    'description' => [
                        'required',
                        'string',
                    ],
                    'isbn' => [
                        'required',
                        'string',
                    ],
                    'publication_year' => [
                        'required',
                        'integer',
                    ],
                    'location' => [
                        'required',
                        'string',
                    ]
                ];
            case 'PATCH':
                return [
                    'category_id' => [
                        'sometimes',
                        'required',
                        'integer',
                        'exists:categories,id',
                    ],
                    'author_id' => [
                        'sometimes',
                        'required',
                        'integer',
                        'exists:authors,id',
                    ],
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
                    ]
                ];
            default:
                return [];
        }
    }
}
