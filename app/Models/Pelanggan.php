<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\MustVerifyEmail as HasVerifiedEmail;


class Pelanggan extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasVerifiedEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'pelanggan';

    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at'
    ];

    // Metode tambahan untuk memastikan verifikasi email
    public function hasVerifiedEmail()
    {
        return $this->email_verified_at !== null;
    }

    // Optional: Override metode untuk mengirim notifikasi email
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \Illuminate\Auth\Notifications\VerifyEmail);
    }
    
    public function keranjang()
    {
        return $this->hasMany(Pesanan::class);
    }
        
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
