<?php

namespace App\Classes\Error;

class Error extends BaseError
{
    //資源驗證錯誤
    const INVALID_INPUT = 1000;

    //資源不存在
    const RESOURCE_NOT_FOUND = 2000;

    //資料庫錯誤
    const DATABASE_ERROR = 3000;
    const RESOURCE_ESTABLISH_FAILED = 3001;

    protected array $errorMessages = array(
        //資源驗證錯誤
        self::INVALID_INPUT => '無效的參數。',

        //資源不存在
        self::RESOURCE_NOT_FOUND => '不存在的資料。',

        //資料庫錯誤
        self::DATABASE_ERROR => '資料庫錯誤。',
        self::RESOURCE_ESTABLISH_FAILED => '資源建立失敗。'
    );
}
