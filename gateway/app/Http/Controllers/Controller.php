<?php

namespace App\Http\Controllers;

use App\Http\Common\Enums\HttpStatusCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

abstract class Controller
{
    protected array $validatedData;

    protected function jsonResponse(array $data, int $statusCode = 200): JsonResponse
    {
        return response()->json($data, $statusCode);
    }

    protected function wrap(FormRequest $request, callable $callback): JsonResponse
    {
        $this->validatedData = $request->validated();
        try {
            $callback($this->validatedData);

            return $this->jsonResponse([
                'success' => true,
                'error' => null,
            ], HttpStatusCode::OK->value);
        } catch (\Exception $e) {
            return $this->jsonResponse([
                'success' => false,
                'error' => $e->getMessage(),
            ], $e->getCode() ?: HttpStatusCode::INTERNAL_SERVER_ERROR->value);
        }
    }
}
