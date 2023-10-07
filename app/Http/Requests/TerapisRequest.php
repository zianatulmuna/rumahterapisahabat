<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TerapisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules1(): array
    {
        return [
            'nama' => 'required|max:50',
            'no_telp' => 'required|numeric|min_digits:8|max_digits:14',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required',
            'agama' => 'max:20',
            'foto' => 'nullable|file|image|max:1024',
        ];
    }

    public function rules2($id_terapis): array
    {
        return [
            'username' => [
                'required',
                'min:3',
                'max:30',
                'regex:/^\S*$/u',
                Rule::unique('admin')->ignore($id_terapis, 'id_admin'),
                Rule::unique('terapis')->ignore($id_terapis, 'id_terapis')
            ],
            'password' => 'nullable|regex:/^\S*$/u|min:3|max:60',
            'tingkatan' => 'required',             
            'total_terapi' => 'nullable|numeric|max_digits:10',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Kolom :attribute harus diisi.',
            'max' => 'Kolom :attribute harus diisi maksimal :max karakter.',
            'foto.max' => 'Ukuran foto maksimal 1 MB.',
            'min' => 'Kolom :attribute harus diisi minimal :min karakter.',
            'min_digits' => 'Kolom :attribute harus diisi minimal :min digit angka.',
            'max_digits' => 'Kolom :attribute harus diisi minimal :max digit angka.',
            'numeric' => 'Kolom :attribute harus diisi angka.',
            'file' => 'Kolom :attribute harus diisi file.',
            'image' => 'Kolom :attribute harus diisi file gambar.',
            'date' => 'Data yang dimasukkan harus berupa tanggal dengan format Bulan/Tanggal/Tahun.',
            'username.unique' => 'Username sudah dipakai.',
            'username.regex' => 'Username tidak boleh mengandung spasi.',
            'email' => 'Format email salah'
        ];
    }
}
