<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'company_name' => 'required|string|max:550',
            'designation' => 'required|string|max:550',
            'city' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'user_id' => 'required|exists,users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'description' => 'required|string',
        ];
    }
}
