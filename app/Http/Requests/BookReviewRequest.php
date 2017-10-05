<?php

namespace App\Http\Requests;

class BookReviewRequest extends Request
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
                    'rating' => [
                        'required',
                        'integer'
                    ],
                    'comment' => [
                        'string'
                    ]
                ];
            case 'PATCH':
                return [
                    'rating' => [
                        'sometimes',
                        'required',
                        'integer',
                    ],
                    'comments' => [
                        'string'
                    ]
                ];
            default:
                return [];
        }
    }
}
