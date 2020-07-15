<?php

namespace App\Classes\Converter;

use App\Classes\Error\ApiError;

class OutputConverter
{
    /**
     * 轉換結果
     *
     * @param  bool|null $isOk
     * @param  ApiError $apiError
     * @return array
     */
    public static function convertResult(?bool $isOk, ApiError $apiError = null) : array
    {
        if (is_null($apiError)) {
            $apiError = new ApiError();
        }

        $outputContent = $apiError->toArray();
        $outputContent['Result'] = null;
        if ( ! is_null($isOk)) {
            $outputContent['Result'] = array();
            $outputContent['Result']['IsOK'] = $isOk;
        }

        return $outputContent;
    }
}
