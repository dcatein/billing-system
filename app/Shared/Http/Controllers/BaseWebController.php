<?php

namespace App\Shared\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

abstract class BaseWebController extends Controller
{
    protected string $route;

    protected function success(string $message, string $targetRoute = 'index'): RedirectResponse
    {
        return redirect()
            ->route($this->route . '.' . $targetRoute)
            ->with('success', $message)
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

    protected function error(\Throwable $e, string $view, $param = null): RedirectResponse
    {
        if ($e instanceof ValidationException) {
            return redirect()
                ->route($this->route . '.' . $view, $param)
                ->withErrors($e->errors())
                ->withInput();
    }

        return redirect()
            ->route($this->route . '.' . $view, $param)
            ->withErrors(['error' => $e->getMessage()])
            ->withInput();
    }
}