<?php

namespace App\Http\Requests\Admin\Companies;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
        return [
            'company_name' => ['required','string','max:254'],
            'company_email' => ['nullable', 'string', 'email', 'max:254'],
            'company_website' => ['nullable','string','max:254'],
            'company_logo' => ['image', 'mimes:jpg,png', 'dimensions:min_width=100,min_height=100'],
        ];
    }
}
