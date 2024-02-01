<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\User;
use Laravel\Passport\Passport;



class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('access-admin', function (User $user): bool { // Define a new gate for the admin role para acceder a la ruta /admin
            return $user->rol_id === 1;
        });


        Passport::tokensExpireIn(now()->addDays(15)); // Define the expiration time for the token
        Passport::refreshTokensExpireIn(now()->addDays(30)); // Define the expiration time for the refresh token
        Passport::enableImplicitGrant(); // Enable the implicit grant

        Passport::tokensCan([ // Define the scopes for the token
            'manage-rol-state' => 'ver los roles y productos disponibles',
            'manage-rol-user' => 'obtener los usuarios por rol',
            'manage-account' => 'Obtener la informacion de la cuenta, nombre, email, estado (sin contraseña), modificar datos como email, nombre y contraseña.',
            'update' => 'actualizar productos, galerias',
            'store' => 'crear productos, galerias',
            'destroy' => 'eliminar productos, galerias',
        ]);
    }
}
