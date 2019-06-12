<?php

namespace App\Http\Requests;

class BookAuthorRequest extends Request
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
                    'author_id' => [
                        'required',
                        'integer',
                        'exists:authors,id',
                    ],
                ];
            default:
                return [];
        }
    }
}
