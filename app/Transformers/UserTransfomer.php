<?php

namespace App\Transformers;
use App\Models\User;

class UserTransformer
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'rol_id' => $user->rol_id,
            'is_verified' => $user->is_verified,
            'verification_token' => $user->verification_token,
            'created_at' => $user->created_at,

            'links' => [
                 
                [
                    'rel' => 'self',
                    'href' => route('users.show', $user->id),
                ],
            
        ]

        ];
    }

    public function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'name' => 'name',
            'email' => 'email',
            'phone' => 'phone',
            'rol_id' => 'rol_id',
            'is_verified' => 'is_verified',
            'verification_token' => 'verification_token',
            'created_at' => 'created_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}