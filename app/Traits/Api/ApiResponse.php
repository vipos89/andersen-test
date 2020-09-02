<?php
declare(strict_types=1);

namespace App\Traits\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse
{
    /**
     * @param $message
     * @param null $data
     * @param $statusCode
     * @param bool $isSuccess
     *
     * @return JsonResponse
     */
    public function baseResponse($message, $statusCode, $data = null, $isSuccess = true): JsonResponse
    {
        $responseData = [
            'message' => $message,
            'error' => !$isSuccess,
            'code' => $statusCode
        ];
        if ($isSuccess) {
            $responseData['data'] = $data;
        }
        return response()->json($responseData, $statusCode);
    }

    /**
     * @param $message
     * @param $data
     * @param int $code
     *
     * @return JsonResponse
     */
    public function successResponse($message, $data, $code = Response::HTTP_OK): JsonResponse
    {
        return $this->baseResponse($message, $code, $data);
    }

    /**
     * @param $message
     * @param $data
     * @param int $code
     *
     * @return JsonResponse
     */
    public function errorResponse($message, $code = Response::HTTP_INTERNAL_SERVER_ERROR, $data = null): JsonResponse
    {
        return $this->baseResponse($message,  $code, $data);
    }
}
