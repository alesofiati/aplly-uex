<?php

namespace App\Http\Requests;

use App\Http\Requests\Api\ApiValidationErrors;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{

    use ApiValidationErrors;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            "email" => "required|email",
            "token" => "required|string",
            "password" => "required|min:6|max:12|confirmed",
            'password_confirmation' => 'required|min:6|max:12'
        ];
    }
}
