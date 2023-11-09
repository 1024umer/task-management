<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProposalRequest extends FormRequest
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
            'duration' => 'required|string|max:550',
            'amount' => 'required|string',
            'cover' => 'required',
            'proposal_images' => 'required|sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
