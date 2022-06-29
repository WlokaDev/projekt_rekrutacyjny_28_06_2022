<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

trait ApiResponseTrait
{
    /**
     * @param mixed $data
     * @param int $statusCode
     * @return JsonResponse
     */

    public function successResponse(mixed $data, int $statusCode = 200) : JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'data' => $data,
            'code' => $statusCode
        ]);
    }

    /**
     * @param mixed $data
     * @param string|null $message
     * @param int $statusCode
     * @return JsonResponse
     */

    public function errorResponse(mixed $data, ?string $message = null, int $statusCode = ResponseAlias::HTTP_BAD_REQUEST) : JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'data' => $data,
            'message' => $message
        ], $statusCode);
    }
}
