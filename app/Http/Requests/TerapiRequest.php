<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TerapiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules1($id_sub, $id_terapis, $tanggal): array
    {
        return [
            'id_terapis' => [
                Rule::requiredIf(empty($id_terapis)),
            ],
            'pra_terapi' => 'max:100',
            'post_terapi' => 'max:100',
            'tanggal' => [
                'required',
                'date',
                Rule::unique('rekam_terapi', 'tanggal')->where(function ($query) use ($id_sub, $id_terapis, $tanggal) {
                    return $query->where('tanggal', '!=', $tanggal)->where('id_sub', $id_sub)->where('id_terapis', $id_terapis);
                }),
            ]
        ];
    }

    public function rules2(): array
    {
        return [
            'keluhan' => 'required|max:300',
            'deteksi' => 'required|max:300',
            'tindakan' => 'required|max:300',
            'saran' => 'max:300',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Kolom :attribute harus diisi.',
            'id_terapis.required' => 'Kolom terapis harus diisi.',
            'max' => 'Kolom :attribute harus diisi maksimal :max karakter.',
            'date' => 'Data yang dimasukkan harus berupa tanggal dengan format Bulan/Tanggal/Tahun.',
            'tanggal.unique' => 'Tanggal sudah ada.'
        ];
    }
}
