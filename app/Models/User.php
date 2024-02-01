<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str; 
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    const isVerified = true;
    const isNotVerified = false;

    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol_id',
        'is_verified',
        'verification_token',
        // 'phone'
    ];

 
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    //mutador para el campo name para que siempre se guarde en minusculas
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    //accesor para el campo email para que siempre se muestre en minusculas
    public function getEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    //método para verificar el usuario
    public function isVerified()
    {
        return $this->is_verified == User::isVerified;
    }

    //método para generar el token de verificación
    public static function generateVerificationToken()
    {
        return Str::random(40);
    }

    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    //     'password' => 'hashed', //
    // ];
}
