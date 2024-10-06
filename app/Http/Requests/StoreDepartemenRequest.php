<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartemenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true
        ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_departemen' => 'required|max:100',
        ];
    }

    // public function messages(): array
    // {
    //     return [
    //         'nama_departemen.required' => 'Kasih nama departemen dong',
    //         'nama_departemen.max' => 'Kepanjangan woy',
    //     ];
    // }
}
