<?php

namespace App\Http\Requests;

class EbookRequest extends Request
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
                $rules =  [
                    'category_id' => [
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

                $files = count($this->input('files'));
                foreach(range(0, $files) as $index) {
                    $rules['files.' . $index] = 'file:mimes:pdf,epub,mobi';
                }

                return $rules;
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
