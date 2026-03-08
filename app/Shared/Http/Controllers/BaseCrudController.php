<?php

namespace App\Shared\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

abstract class BaseCrudController extends Controller
{
    protected string $route;

    protected function success(string $message): RedirectResponse
    {
        return redirect()
            ->route($this->route . '.index')
            ->with('success', $message)
            ->setStatusCode(Response::HTTP_SEE_OTHER);
    }

    protected function successStore(): RedirectResponse
    {
        return $this->success('Registro criado com sucesso!');
    }

    protected function successUpdate(): RedirectResponse
    {
        return $this->success('Registro atualizado com sucesso!');
    }

    protected function successDelete(): RedirectResponse
    {
        return $this->success('Registro excluído com sucesso!');
    }
}