<?php

namespace App\Http\Requests;

class BookTagRequest extends Request
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
                    'tag' => [
                        'required'
                    ],
                ];
            default:
                return [];
        }
    }
}
