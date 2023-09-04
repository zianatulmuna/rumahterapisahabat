<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class KepalaTerapis extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    protected $table = 'kepala_terapis';
    protected $guarded = [];
    protected $primaryKey = 'id_kepala';


    protected $guard = 'kepala_terapis';

    public $incrementing = false;
}