<?php

namespace App\Http\Requests;

class VideoRequest extends Request
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
                    'release_date' => [
                        'sometimes',
                        'required',
                        'date:Y-m-d',
                    ],
                    'runtime' => [
                        'sometimes',
                        'required',
                        'integer'
                    ],
                    'content_rating' => [
                        'sometimes',
                        'required',
                        'string'
                    ],
                    'location' => [
                        'string',
                    ],
                    'thumbnail_path' => [
                        'string'
                    ],
                    'header_path' => [
                        'string'
                    ],
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
                    'release_date' => [
                        'sometimes',
                        'required',
                        'date:Y-m-d',
                    ],
                    'runtime' => [
                        'sometimes',
                        'required',
                        'integer'
                    ],
                    'content_rating' => [
                        'sometimes',
                        'required',
                        'string'
                    ],
                    'location' => [
                        'string',
                    ],
                    'thumbnail_path' => [
                        'string'
                    ],
                    'header_path' => [
                        'string'
                    ],
                ];
            default:
                return [];
        }
    }
}
