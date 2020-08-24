<?php
declare(strict_types = 1);

namespace App\Traits\Api;


trait ApiResponse
{
    /**
     * @param $message
     * @param null $data
     * @param $statusCode
     * @param bool $isSuccess
     * @return \Illuminate\Http\JsonResponse
     */
    public function baseResponse($message, $data = null, $statusCode, $isSuccess = true): \Illuminate\Http\JsonResponse
    {
        if (!$message) {
            return $this->baseResponse();
        }

        $responseData = [
            'message' => $message,
            'error' => $isSuccess,
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($message, $data, $code = 200): \Illuminate\Http\JsonResponse
    {
        return $this->baseResponse($message, $data, $code);
    }

    /**
     * @param $message
     * @param $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $data, $code = 500): \Illuminate\Http\JsonResponse
    {
        return $this->baseResponse($message, $data, $code);
    }
}
