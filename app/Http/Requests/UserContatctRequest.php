<?php

namespace App\Http\Requests;

use App\Http\Requests\Api\ApiValidationErrors;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\DocumentUniquePerUserRules as UniqueCpf;

class UserContatctRequest extends FormRequest
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

    public function prepareForValidation(): void
    {
        $this->merge([
            "document_number" => onlyNumbers((string)$this->document_number),
            "phone_number" => onlyNumbers((string)$this->phone_number)
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {

        $validation = [
            "name" => "required|min:3|max:60",
            "document_number" => ["required","cpf", new UniqueCpf()],
            "phone_number" => "required|min:10|max:11",
            "street" => "required|min:6",
            "street_number" => "required|min:2|max:6",
            "neighborhood" => "required|min:3",
            "city" => "required|min:3",
            "state" => "required|min:2",
        ];

        $contatoId = isset($this->route()->parameters['contatoId']) 
            ? $this->route()->parameters['contatoId'] 
            : null;

        if($contatoId){
            $validation = [
                ...$validation,
                "document_number" => "required|cpf",
            ];
        }
        
        return $validation;
    }
}
