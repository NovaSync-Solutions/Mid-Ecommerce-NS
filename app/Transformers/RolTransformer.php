<?php

namespace App\Transformers;
use App\Models\User;

class RolTransformer
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'created_at' => $user->created_at,

        ];
    }

    // public function originalAttribute($index)
    // {
    //     $attributes = [
    //         'id' => 'id',
    //         'name' => 'name',
    //         'email' => 'email',
    //         'phone' => 'phone',
    //         'rol_id' => 'rol_id',
    //         'is_verified' => 'is_verified',
    //         'verification_token' => 'verification_token',
    //         'created_at' => 'created_at',
    //     ];

    //     return isset($attributes[$index]) ? $attributes[$index] : null;
    // }
}