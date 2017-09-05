<?php

namespace App\Http\Requests;

class CoverImageRequest extends Request
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
                    'cover_image' => [
                        'required',
                        'image'
                    ]
                ];
            default:
                return [];
        }
    }
}
