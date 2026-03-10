<?php

namespace App\Domains\Users\Services;

use App\Domains\Users\Repositories\Contracts\UsersRepositoryInterface;

class UsersService
{
    public function __construct(
        protected UsersRepositoryInterface $usersRepository
        ) {}

    public function all() 
    {
        return $this->usersRepository->getAll();
    }
}
