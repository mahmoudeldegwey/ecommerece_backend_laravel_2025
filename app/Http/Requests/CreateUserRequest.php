<?php
namespace App\Http\Requests;

class CreateUserRequest extends ApiRequest
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
            'name' => ['required','unique:users,name'],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ];
    }
}