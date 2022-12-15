<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Api\ApiValidationErrors;

class UserRequest extends FormRequest
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

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|min:5|max:30',
            'password' => 'required|min:6|max:12|confirmed',
            'password_confirmation' => 'required|min:6|max:12'
        ];
    }

}
