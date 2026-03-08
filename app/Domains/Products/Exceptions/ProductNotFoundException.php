<?php

namespace App\Domains\Products\Exceptions;

use App\Shared\Exceptions\DomainException;
use Symfony\Component\HttpFoundation\Response;

class ProductNotFoundException extends DomainException
{
    protected $message = 'Produto não encontrado';
    protected int $status = Response::HTTP_NOT_FOUND;
}