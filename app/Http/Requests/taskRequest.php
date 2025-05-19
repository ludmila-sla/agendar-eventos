<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class taskRequest extends FormRequest
{
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
            "user" => "required|string",
            "name" => "required|string",
            "duration" => "required|integer|min:1",
            "priority" => "required|string|in:1,2,3,4,5",
            "status" => "required|string|in:open,closed,processing",
            "description" => "sometimes|string"
        ];
    }
}
