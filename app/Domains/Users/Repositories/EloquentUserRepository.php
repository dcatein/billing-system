<?php

namespace App\Domains\Users\Repositories;

use App\Domains\Users\Repositories\Contracts\UsersRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Collection;

class EloquentUserRepository implements UsersRepositoryInterface
{
    public function getAll(): Collection
    {
        return User::all();
    }
}