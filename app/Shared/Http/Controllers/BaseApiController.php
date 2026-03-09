<?php

namespace App\Shared\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

abstract class BaseApiController extends Controller
{

    protected function success(mixed $data = null, string $message = 'Operação realizada com sucesso'): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], Response::HTTP_OK);
    }

    protected function error(string $message = 'Erro na operação', int $status = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $status);
    }

    protected function exception(\Throwable $e): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Erro interno.',
            'details' => $e->getMessage()
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}