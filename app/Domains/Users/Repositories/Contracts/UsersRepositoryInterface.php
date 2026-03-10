<?php

namespace App\Domains\Users\Repositories\Contracts;

use Illuminate\Support\Collection;

interface UsersRepositoryInterface
{
    public function getAll(): Collection;
}
