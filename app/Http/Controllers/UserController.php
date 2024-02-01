<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import the User class from the correct namespace
use Illuminate\Http\JsonResponse;

class UserController extends ApiController
{
    public function index()//metodo para mostrar todos los usuarios
    {
        $usuarios = User::all();
        return $this->showAll($usuarios);
    }
    public function store(Request $request) //metodo para crear un usuario
    {
          $request -> validate([
           'name' => 'required',
           'email' => 'required|email|unique:users',
           'password' => 'min:8',
        ]);
  
        $campos = $request->all();
        $campos['password'] = bcrypt($request->password);
        $campos['verified'] = User::isNotVerified;
        $campos['verification_token'] = User::generateVerificationToken();
        $campos['rol_id'] = 2;
     
        $usuario = User::create($campos);
        $usuario->roles()->attach($campos['rol_id']); // Insertar el rol en la tabla pivote
        return $this->showOne($usuario, 201);
    }
    public function show(User $user) //metodo para mostrar un usuario
    {
         return $this->showOne($user, 200);
    }
    // public function update(Request $request, User $user) //metodo para actualizar un usuario
    // {
    //   /*  $usuarioExistente = User::where('email', $request->input('email'))->exists();
    
    //    if ($usuarioExistente) {
    //        return $this->errorResponse('Ya existe un usuario con el mismo Email', 400);
    //    }*/
      
    //      $request->validate([
    //       'email' => 'email',
    //       'password' => 'min:8',]);

    //     $user->fill($request->only([
    //        'email',
    //     ]));
       
    //     if($request->has('name')){  //si el request tiene el campo name
    //         $user->name = $request->name;   //se actualiza el nombre   
    //     }

    //     if($request->has('email') && $user->email != $request->email){ //si el request tiene el campo email y el email del usuario es diferente al email del request
    //         $user->is_verificado = User::NO_VERIFICADO;  //se actualiza el estado de verificacion
    //         $user->verification_token = User::generateVerificationToken();  //se genera un nuevo token de verificacion
    //         $user->email = $request->email; //se actualiza el email
    //         $user->save(); //se guarda el usuario
    //     } 

    //     if($request->has('password')){    //si el request tiene el campo password
    //         $user->password = bcrypt($request->password);   //se actualiza el password
    //     }

    //    /* if ($request->has('rol_id')) { //si el request tiene el campo role
    //        if(!$user->isVerificado()){ //si el usuario no esta verificado
    //          return $this->errorResponse('Unicamente los usuarios verificados pueden cambiar su rol', 409);
    //        }
    //        $user->rol_id = $request->rol_id; //se actualiza el rol
    //     }
    //     if ($request->has('rol_id')) {
    //         $user->roles()->sync([$request->rol_id]);
    //     }*/
    //     if ($request->has('rol_id')) {
    //         if(!$user->isVerificado()){ //si el usuario no está verificado
    //             return $this->errorResponse('Unicamente los usuarios verificados pueden cambiar su rol', 409);
    //         }
           
    //         $user->rol_id = $request->rol_id; //se actualiza el rol
    //         $roles = [$request->rol_id]; //se crea un array con el id del rol
    //         $user->roles()->sync($roles); //se sincroniza el rol
    //     }
        
    //     if ($user->isDirty()) {
    //         $user->save();
    //     } else {
    //         return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
    //     }
       
    //     return $this->showOne($user, 200);
    // }
       public function destroy(User $user) //metodo para eliminar un usuario
    {
        $user->delete();
        return $this->showOne($user, 200);
    }
     public function verify($token)//metodo para verificar un usuario
    {
        $user = User::where('verification_token', $token)->firstOrFail();
        $user->is_verificado = User::isVerified;
        $user->verification_token = null;
        $user->save();
    
        return new JsonResponse('El usuario ha sido verificado', 200);
    }
}
