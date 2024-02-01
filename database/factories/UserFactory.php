<?php

namespace Database\Factories;

use App\Models\User; // Import the User class
use App\Models\Rol; // Import the Rol class
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_verificado' => $verificado = fake()->randomElement([User::isVerified, User::isNotVerified]),
            'verification_token' => $verificado == User::isVerified ? null : User::generateVerificationToken(),
            'rol_id' => Rol::inRandomOrder()->first()->id,            // Establecer el ID de rol en la columna de llave foránea en la tabla de usuarios
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
