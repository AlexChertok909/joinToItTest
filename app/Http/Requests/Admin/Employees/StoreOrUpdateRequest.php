<?php

namespace App\Http\Requests\Admin\Employees;

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
            'employee_first_name' => ['required','string','max:254'],
            'employee_last_name' => ['required','string','max:254'],
            'employee_company_id'=>['required','integer','digits_between:1,11','min:1', 'exists:companies,id'],
            'employee_email' => ['nullable', 'string', 'email', 'max:254'],
            'employee_phone' => ['nullable','string','max:254'],
        ];
    }
}
