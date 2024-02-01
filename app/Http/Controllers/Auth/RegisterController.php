<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validations fail', 'errors' => $validator->errors()], 422);
        }

        $campos['name'] = $request->name;
        $campos['email'] = $request->email;
        $campos['password'] = bcrypt($request->password);
        $campos['is_verificado'] = User::isNotVerified;
        $campos['verification_token'] = User::generateVerificationToken();
        $campos['rol_id'] = 2;

        $user = User::create($campos);
        // dd($user);
        $rolName = ($campos['rol_id'] == 2) ? 'Cliente' : 'Admin';


        
        
        $user->roles()->attach($campos['rol_id'], ['user_id' => $user->id]);// Insertar el rol en la tabla pivote
        //   return $this->showOne($usuario, 201);

        return response()->json([
            'message' => 'Registration successful',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'verification_token' => $user->verification_token,
                'phone' => $user->phone,
                'rol' => [
                    'rol_id' => $campos['rol_id'],
                    'rol_name' => $rolName,
                ],
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'links' => [
                    [
                        'rel' => 'self',
                        // 'href' => route('', $user->id),
                    ],
                ],
            ],
        ], 201);
        


        // return response()->json([
        //     'message' => 'RegisterController'
        // ]);
    }
}
