<?php
namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class SettingRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'settings' => 'required|array',
            // 'settings.*.key' => 'required',
            // 'settings.*.value' => 'required'
        ];
    }
}
