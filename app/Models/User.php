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

    public $transformer = UserTransformer::class; //transformador de la clase

    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
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

   // Accesor para el campo email para que siempre se muestre en minúsculas
    public function getEmailAttribute($value)
    {
        return $value;
    }


    //método para verificar el usuario
    public function isVerified()
    {
        return $this->is_verified == User::isVerified;
    }

    public function isNotVerified()
    {
        return $this->is_verified == User::isNotVerified;
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
        
  // En el modelo User
public function roles()
{
    return $this->belongsToMany(Rol::class, 'rol_user', 'user_id', 'rol_id');
}

}
