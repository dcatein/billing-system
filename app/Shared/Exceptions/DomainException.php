<?php

namespace App\Shared\Exceptions;

use Exception;

class DomainException extends Exception
{
    protected int $status = 400;

    public function getStatus(): int
    {
        return $this->status;
    }
}