<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class JadwalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    } 
    public function rules(): array
    {
        $id_jadwal = $this->route('id_jadwal');

        return [
            'id_terapis' => 'nullable',
            'id_pasien' => 'required',
            'id_sub' => 'required',
            'tanggal' => [
                'required',
                'date',
                Rule::unique('jadwal', 'tanggal')
                    ->where(function ($query) {
                        return $query->where('id_pasien', request('id_pasien'))
                            ->where('id_terapis', request('id_terapis'))
                            ->where('id_sub', request('id_sub'));
                    })
                    ->ignore($id_jadwal, 'id_jadwal'),
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Kolom :attribute harus diisi.',
            'id_terapis.required' => 'Terapis harus diisi.',
            'id_pasien.required' => 'Pasien harus diisi.',
            'id_sub.required' => 'Penyakit harus dipilih.',
            'date' => 'Data yang dimasukkan harus berupa tanggal dengan format Bulan/Tanggal/Tahun.',
            'tanggal.unique' => 'Tanggal untuk pasien dan terapis ini sudah ada'
        ];
    }
}
