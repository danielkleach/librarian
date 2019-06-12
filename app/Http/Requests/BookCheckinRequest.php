<?php

namespace App\Http\Requests;

class BookCheckinRequest extends Request
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
                    'user_id' => [
                        'required',
                        'integer',
                    ]
                ];
            default:
                return [];
        }
    }
}
