<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'uuid' => 'required|uuid|unique:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'uuid.unique' => 'UUID já cadastrado.',
            'uuid.required' => 'O campo uuid é obrigatório.',
            'uuid.uuid' => 'O campo uuid não parece ser válido.',
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'o campo email é obrigatório.',
            'email.unique' => 'E-mail já cadastrado.',
        ];
    }
}
