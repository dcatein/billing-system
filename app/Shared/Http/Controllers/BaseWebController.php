<?php

namespace App\Shared\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

abstract class BaseWebController extends Controller
{
    protected string $route;

    protected function success(string $message, string $targetRoute = 'index'): RedirectResponse
    {
        return redirect()
            ->route($this->route . '.' . $targetRoute)
            ->with('success',true)
            ->setStatusCode(Response::HTTP_SEE_OTHER);
    }

    protected function successStore(): RedirectResponse
    {
        return $this->success('Registro criado com sucesso!', 'create');
    }

    protected function successUpdate(): RedirectResponse
    {
        return $this->success('Registro atualizado com sucesso!', 'index')->with('success',true);
    }

    protected function successDelete(): RedirectResponse
    {
        return $this->success('Registro excluído com sucesso!', 'index');
    }

    protected function error(\Throwable $e, string $targetRoute = 'create'): RedirectResponse
    {
        return redirect()
            ->route($this->route . '.' . $targetRoute)
            ->withInput()
            ->with('error', 'Erro na operação.');
    }
}