<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'min:4', 'max:100'],
            'username' => ['required', Rule::unique('users', 'username'), 'min:4', 'max:100', 'regex:/^[0-9a-zA-Z_]+$/'],
            'password' => ['required', Password::min(4)->max(100)],
            'device_name' => ['nullable', 'min:4', 'max:255']
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'failed',
            'data' => null,
            'message' => $validator->errors()->first(),
            'errors' => $validator->errors()->getMessages()
        ], 400));
    }

    public function passedValidation(): void 
    {
        $this->merge([
            'username' => str($this->input('username'))->lower()->toString()
        ]);
    }
}
