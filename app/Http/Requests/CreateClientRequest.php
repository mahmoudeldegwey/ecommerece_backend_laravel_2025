<?php
namespace App\Http\Requests;

class CreateClientRequest extends ApiRequest
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
    public function rules(): array
    {
        return [
            'username'  => ['required','unique:clients,username'],
            'email'     => 'required|email|unique:clients,email',
            'password'  => 'required|confirmed'
        ];
    }
}