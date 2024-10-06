<?php

namespace App\Http\Requests;

use App\Enum\KaryawanStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateKaryawanRequest extends FormRequest
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
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|string|unique:karyawan,email|max:100',
            'password' => 'required|string|min:6',
            'nomor_telepon' => 'required|string|max:15|unique:karyawan,nomor_telepon',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'tanggal_masuk' => 'required|date|after:tanggal_lahir',
            'status' => ['required', 'string', Rule::enum(KaryawanStatus::class)],
            'departemen_id' => [
                'required',
                'integer',
                Rule::exists('departemen', 'id'),
            ],
            'jabatan_id' => [
                'required',
                'integer',
                Rule::exists('jabatan', 'id'),
            ],
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
