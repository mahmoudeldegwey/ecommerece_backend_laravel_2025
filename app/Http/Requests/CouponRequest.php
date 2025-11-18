<?php
namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CouponRequest extends ApiRequest
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
        //dd($this->start_at);

        return [
            'name' => 'required',
            'code' => 'required',
            'start_at' => 'required|after:tomorrow',
            'end_at' => 'required|date|after:start_at',
            'type' => ['required',Rule::in(['fixed','percentage'])],
            'amount' => 'required',
            'usage' => 'required',
        ];
    }

    protected function prepareForValidation() {
        // $this->merge([
        //     'start_at' => strtotime(\Carbon\Carbon::createFromFormat('Y-m-d', $this->start_at)->format('Y-m-d'))
        // ]);
    }
}
