<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    public $transformer = RolTransformer::class; //transformador de la clase
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    
    
    protected $table = 'Rol';


    public static function allRoles() //funcion para obtener todos los roles
    {
        return static::all();
    }
    protected $fillable = [ 
        'id',
        'name_role',
    ];

    // protected $hidden = [ //oculta los campos de la tabla pivote
    //     'pivot'
    // ];
}
