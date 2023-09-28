<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RekamMedisRequest extends FormRequest
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
            'tanggal_pendaftaran' => 'required|date', 
            'tipe_pembayaran' => 'nullable',
            'biaya_pembayaran' => 'max:100',
            'jumlah_bayar' => 'nullable|numeric|max:3',
            'penanggungjawab' => 'max:50',
            'tanggal_ditambahkan' => [
                Rule::requiredIf(!empty($this->id_pasien))
            ],   
            'tempat_layanan' => [
                'max:50',
                Rule::requiredIf($this->tempat_layanan == "")
            ],
            'jadwal_layanan' => 'max:50',
            'sistem_layanan' => 'max:50',
            'jumlah_layanan' => 'max:50',
            'status_pasien' => [
                'required',
                Rule::unique('rekam_medis')->where(function ($query) {
                    $query->where('id_pasien', $this->id_pasien)->where('status_pasien', 'Rawat Jalan');
                }),
            ],
            'status_terapi' => 'required',
            'tanggal_selesai' => [
                Rule::requiredIf($this->status_pasien == 'Selesai' || $this->status_pasien == 'Jeda')
            ],
            'penyakit' => [
                'required_if:tag,0',
                Rule::requiredIf(count($this->tag) == 0),
            ],
            'keluhan' => 'max:100',
            'catatan_fisik' => 'max:100',
            'catatan_psikologis' => 'max:100',
            'catatan_bioplasmatik' => 'max:100',
            'catatan_rohani' => 'max:100',
            'data_deteksi' => 'max:100',
            'link_perkembangan' => 'nullable|url|max:100',
                'kondisi_awal' => 'max:100',
                'target_akhir' => 'max:100',
                'kesimpulan' => 'max:100',
        ];
    }

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
            'date' => 'Data yang dimasukkan harus berupa tanggal dengan format Bulan/Tanggal/Tahun.',
            'status_pasien.unique' => 'Masih ada Rekam Medis dengan status Rawat Jalan.'
        ];
    }
}
