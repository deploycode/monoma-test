<?php

namespace App\Traits;

trait ApiResponse
{
    /**
     * Success response method.
     *
     * @param mixed $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data, $code = 200)
    {
        return response()->json([
            'meta' => [
                'success' => true,
                'errors' => [],
            ],
            'data' => $data,
        ], $code);
    }

    /**
     * Error response method.
     *
     * @param array $errors
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse(array $errors, $code = 400)
    {
        return response()->json([
            'meta' => [
                'success' => false,
                'errors' => $errors,
            ],
            'data' => [],
        ], $code);
    }
}
