<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasienRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|max:50',
            'email' => 'nullable|max:35',
            'alamat' => 'max:100',
            'no_telp' => 'required|min_digits:8',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required',
            'agama' => 'max:20',
            'pekerjaan' => 'max:30',
            'foto' => 'nullable|file|image|max:1024',
            'penanggungjawab' => 'max:50',
            'tipe_pembayaran' => 'nullable',
            'keluhan' => 'required|max:100'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => 'Kolom :attribute harus diisi.',
            'max' => 'Kolom :attribute harus diisi maksimal :max karakter.',
            'foto.max' => 'Kolom :attribute harus diisi maksimal :max kb.',
            'min' => 'Kolom :attribute harus diisi minimal :min karakter.',
            'min_digits' => 'Kolom :attribute harus diisi minimal :min digit angka.',
            'max_digits' => 'Kolom :attribute harus diisi minimal :max digit angka.',
            'numeric' => 'Kolom :attribute harus diisi angka.',
            'url' => 'Kolom :attribute harus berupa link URL valid',
            'file' => 'Kolom :attribute harus diisi file.',
            'image' => 'Kolom :attribute harus diisi file gambar.',
            'date' => 'Data yang dimasukkan harus berupa tanggal dengan format Bulan/Tanggal/Tahun.'
        ];
    }
}
