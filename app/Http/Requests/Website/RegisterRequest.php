<?php
namespace App\Http\Requests\Website;

use Illuminate\Validation\Rule;
use App\Http\Requests\ApiRequest;

class RegisterRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username'  => ['required','unique:clients,username'],
            'email'     => 'required|email|unique:clients,email',
            'password'  => 'required|confirmed'
            //'address' => 'required'
        ];
    }
}
