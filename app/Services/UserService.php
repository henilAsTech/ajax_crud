<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function get($query = null)
    {
        $users = User::query()
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', '%' . $query . '%')
                            ->orWhere('email', 'like', '%' . $query . '%')
                            ->orWhere('gender', 'like', '%' . $query . '%');
            })
            ->get();
        return $users;
    }

    public function create(array $data): User
    {
        $user = User::create($data);
        return $user;
    }

    public function update(array $data): User
    {
        $user = User::find($data['user_id']);
        $user->update($data);
        return $user;
    }
}