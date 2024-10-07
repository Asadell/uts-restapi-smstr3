<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreGajiRequest extends FormRequest
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
            'karyawan_id' => [
                'required',
                'integer',
                Rule::exists('karyawan', 'id'),
            ],
            'bulan' => 'required|string|max:15',
            'gaji_pokok' => 'required|decimal:0,2',
            'tunjangan' => 'required|decimal:0,2',
            'potongan' => 'required|decimal:0,2',
            'total_gaji' => 'required|decimal:0,2',
        ];
    }

    public function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors occurred',
            'data' => $validator->errors(),
        ], 400));
    }
}
