<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\TerapisController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\RekamTerapiController;
use App\Http\Controllers\SubRekamMedisController;

Route::get('/', [DashboardController::class, 'landingPage']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/daftar-sebagai-pasien', [PasienController::class, 'addPrapasien'])->name('landing.form');
Route::post('/daftar-sebagai-pasien', [PasienController::class, 'store'])->name('landing.store');

Route::middleware('auth:admin,terapis,kepala_terapis')->group(function () {
    Route::get('/beranda', [DashboardController::class, 'index'])->name('beranda');
    
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::get('/pasien/lama', [PasienController::class, 'allPasien'])->name('pasien.lama');

    Route::get('/rekam-terapi/tag', [SubRekamMedisController::class, 'tagPenyakit'])->name('terapi.tag');

    Route::prefix('pasien/{pasien}')->group(function () {
        Route::get('', [PasienController::class, 'detail'])->name('pasien.rm');

        Route::prefix('rekam-medis')->group(function () {
            Route::get('', [RekamMedisController::class, 'histori'])->name('rm.histori');            
            Route::get('/{rekamMedis}', [RekamMedisController::class, 'detail'])->name('rm.detail');
            Route::get('/{rekamMedis}/print', [RekamMedisController::class, 'print'])->name('rm.print');
        });

        Route::prefix('rekam-terapi')->group(function () {
            Route::get('', [SubRekamMedisController::class, 'histori'])->name('sub.histori');            
            Route::get('/{subRM}', [SubRekamMedisController::class, 'detail'])->name('terapi.rekam');

            Route::get('/{subRM}/semua-harian/print', [SubRekamMedisController::class, 'printHarian'])->name('sub.print');

            Route::get('/{subRM}/print', [SubRekamMedisController::class, 'printRekam'])->name('rekam.print');

            Route::get('/{subRM}/harian/tambah', [RekamTerapiController::class, 'add'])->name('terapi.tambah');
            Route::post('/{subRM}/harian/store', [RekamTerapiController::class, 'store'])->name('terapi.store');
            Route::get('/{subRM}/harian/{terapi}', [RekamTerapiController::class, 'detail'])->name('terapi.detail');
            Route::get('/{subRM}/harian/{terapi}/edit', [RekamTerapiController::class, 'edit'])->name('terapi.edit');
            Route::put('/{subRM}/harian/{terapi}', [RekamTerapiController::class, 'update'])->name('terapi.update');
            Route::delete('/{subRM}/harian/{terapi}', [RekamTerapiController::class, 'delete'])->name('terapi.delete');       
            
            Route::get('/{subRM}/harian/{terapi}/print', [RekamTerapiController::class, 'print'])->name('terapi.print');
            
        });
    });    
    
    Route::prefix('jadwal')->group(function () {
        Route::get('', [JadwalController::class, 'index'])->name('jadwal');
        Route::get('/print', [JadwalController::class, 'print'])->name('jadwal.print');

        Route::get('/{pasien}/{jadwal}/tambah', [JadwalController::class, 'addTerapiFromJadwal'])->name('jadwal.isi');
    });
});

Route::middleware('auth:admin,terapis')->group(function () {    
    Route::prefix('pasien-baru')->group(function () {
        Route::get('', [PasienController::class, 'allPrapasien'])->name('pasien.baru');
        Route::get('/create', [PasienController::class, 'addPasien'])->name('pasien.create');
        Route::get('/{pasien}/edit', [PasienController::class, 'edit'])->name('pasien.edit');
    });

    Route::prefix('pasien/{pasien}')->group(function () {      

        Route::prefix('rekam-medis')->group(function () {
            Route::get('/histori/tambah', [RekamMedisController::class, 'add'])->name('rm.create');
            Route::get('/{rekamMedis}/edit', [RekamMedisController::class, 'edit'])->name('rm.edit');
            
            
        });
    }); 

    Route::get('/terapis', [TerapisController::class, 'index'])->name('terapis');    
    Route::get('/terapis/detail/{terapis}', [TerapisController::class, 'detail'])->name('terapis.detail');
});

Route::middleware('auth:admin')->group(function () {    

    Route::prefix('pasien/{pasien}')->group(function () {
        Route::delete('', [PasienController::class, 'delete'])->name('pasien.delete');

        Route::prefix('rekam-medis')->group(function () {
            Route::delete('/{rekamMedis}', [RekamMedisController::class, 'delete'])->name('rm.delete');
        });

        Route::prefix('rekam-terapi')->group(function () {    
            Route::delete('/{subRM}', [SubRekamMedisController::class, 'delete'])->name('sub.delete');     
        });

    }); 

    Route::prefix('jadwal')->group(function () {        
        Route::get('/tambah', [JadwalController::class, 'add'])->name('jadwal.add');
        Route::post('/tambah', [JadwalController::class, 'store'])->name('jadwal.store');
        Route::get('/{pasien}&{jadwal}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
        Route::put('/{jadwal}/update', [JadwalController::class, 'update'])->name('jadwal.update');
        Route::delete('/{jadwal}/delete', [JadwalController::class, 'delete'])->name('jadwal.delete');

        Route::get('/tambah/getSubRekamMedis', [JadwalController::class, 'getSubRekamMedis']);
    });

    Route::prefix('terapis')->group(function () {        
        Route::get('/tambah', [TerapisController::class, 'add'])->name('terapis.add');
        Route::delete('/detail/{terapis}', [TerapisController::class, 'delete'])->name('terapis.delete');
        Route::get('/detail/{terapis}/edit', [TerapisController::class, 'edit'])->name('terapis.edit');
    });
});

Route::middleware('auth:terapis')->group(function () {
    Route::get('/setTerapisReady', [TerapisController::class, 'setReady']);

    Route::get('/sesi-terapi/{terapis}', [TerapisController::class, 'detail'])->name('sesi.terapi');

    Route::prefix('jadwal')->group(function () {
        Route::get('/{pasien}/{jadwal}/lepas', [JadwalController::class, 'cancelJadwal'])->name('jadwal.lepas');
    });
});
