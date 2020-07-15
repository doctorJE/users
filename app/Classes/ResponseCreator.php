<?php

namespace App\Classes;

use Illuminate\Http\JsonResponse;

class ResponseCreator
{
    const DEFAULT_HEADERS = array(
        'Content-type' => 'application/json; charset=utf-8',
        'Cache-Control' => 'no-cache, private'
    );

    /**
     * 建立成功回應
     *
     * @param  array $outputContent
     * @param  int   $statusCode
     * @param  array $header
     * @return JsonResponse
     */
    public static function createResponse(array $outputContent, int $statusCode, array $header = array()): JsonResponse
    {
        $headers = array_merge(self::DEFAULT_HEADERS, $header);

        return response()
            ->json($outputContent
                , $statusCode
                , $headers
                , JSON_UNESCAPED_UNICODE);
    }
}
