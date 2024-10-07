<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthRequest extends FormRequest
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
            'email' => 'required|string|email|exists:karyawan,email',
            'password' => 'required|string'
        ];
    }

    public function failedValidation(Validator $validator) {
        $errors = $validator->errors();

        if($errors->has('email')  && $errors->first('email') === 'Incorrect email') {
            $message = $this->messages()['email.exists'];
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => $message,
                'data' => $errors,
            ], 401));
        }

        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors occurred',
            'data' => $errors,
        ], 400));
    }

    public function messages(): array
    {
        return [
            'email.exists' => 'Incorrect email',
        ];
    }
}
