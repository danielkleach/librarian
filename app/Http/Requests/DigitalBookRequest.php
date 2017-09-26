<?php

namespace App\Http\Requests;

class DigitalBookRequest extends Request
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
                    'cover_image_url' => [
                        'string'
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
                    'cover_image_url' => [
                        'string'
                    ]
                ];
            default:
                return [];
        }
    }
}
