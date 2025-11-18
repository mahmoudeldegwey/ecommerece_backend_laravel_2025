<?php
namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class ProductReviewRequest extends ApiRequest
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
            'username' => ['required'],
            'email' => ['required','email'],
            'phone_number' => ['required'],
            'image' => ['required','image','file'],
            'rate' => ['required','integer'],
            'message' => 'required'
        ];
    }
}
