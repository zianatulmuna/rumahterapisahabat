<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PasienRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules1(): array
    {
        return [
            'nama' => 'required|max:50',
            'email' => 'nullable|email|max:50',
            'alamat' => 'max:100',
            'no_telp' => 'required|min_digits:8|max_digits:14',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required',
            'agama' => 'max:20',
            'pekerjaan' => 'max:35'
        ];
    }

    public function rules2($id_pasien): array
    {
        return [
            'foto' => 'nullable|file|image|max:1024',
            'tanggal_pendaftaran' => 'required|date', 
            'tipe_pembayaran' => 'nullable',
            'biaya_pembayaran' => 'max:150',
            'jumlah_bayar' => 'nullable|numeric|max_digits:3',
            'penanggungjawab' => 'max:50',
            'tanggal_registrasi' => [
                Rule::requiredIf(!empty($id_pasien))
            ],   
        ];
    }
    public function rules3($id_pasien,$id_rekam_medis,$tempat_layanan,$status_pasien,$tempatOption): array
    {
        return [
            'tempatOption' => 'required',
            'tempat_layanan' => [
                'max:150',
                Rule::requiredIf($tempat_layanan == "" && $tempatOption == 'lainnya')
            ],
            'jadwal_layanan' => 'max:50',
            'sistem_layanan' => 'max:50',
            'jumlah_layanan' => 'max_digits:3',
            'status_pasien' => [
                'required',
                Rule::unique('rekam_medis')->ignore($id_rekam_medis, 'id_rekam_medis')
                    ->where(function ($query) use ($id_pasien) {
                        $query->where('id_pasien', $id_pasien)->where('status_pasien', 'Rawat Jalan');
                    }),
            ],
            'status_terapi' => 'required',
            'tanggal_selesai' => [
                Rule::requiredIf($status_pasien == 'Selesai' || $status_pasien == 'Jeda')
            ]
        ];
    }
    public function rules4($tag): array
    {
        return [
            'penyakit' => [
                Rule::requiredIf($tag == 0),
            ],
            'keluhan' => 'max:200',
            'catatan_fisik' => 'max:300',
            'catatan_psikologis' => 'max:300',
            'catatan_bioplasmatik' => 'max:300',
            'catatan_rohani' => 'max:300',
            'data_deteksi' => 'max:300'
        ];
    }
    public function rules5(): array
    {
        return [
            'link_perkembangan' => 'nullable|url|max:100',
            'kondisi_awal' => 'max:300',
            'target_akhir' => 'max:300',
            'kesimpulan' => 'max:300',
        ];
    }
    public function rules6($is_private): array
    {
        return [
            'id_terapis' => [
                Rule::requiredIf($is_private)
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Kolom :attribute harus diisi.',
            'id_terapis.required' => 'Terapis harus diisi.',
            'tempatOption.required' => 'Kolom tempat layanan harus diisi.',
            'max' => 'Kolom :attribute harus diisi maksimal :max karakter.',
            'foto.max' => 'Ukuran foto maksimal 1 MB.',
            'min' => 'Kolom :attribute harus diisi minimal :min karakter.',
            'min_digits' => 'Kolom :attribute harus diisi minimal :min digit angka.',
            'max_digits' => 'Kolom :attribute harus diisi minimal :max digit angka.',
            'numeric' => 'Kolom :attribute harus diisi angka.',
            'url' => 'Kolom :attribute harus berupa link URL valid',
            'file' => 'Kolom :attribute harus diisi file.',
            'image' => 'Kolom :attribute harus diisi file gambar.',
            'date' => 'Data yang dimasukkan harus berupa tanggal dengan format Bulan/Tanggal/Tahun.',
            'status_pasien.unique' => 'Masih ada Rekam Medis dengan status Rawat Jalan.',
            'email' => 'Format email salah'
        ];
    }
}
