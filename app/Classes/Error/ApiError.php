<?php

namespace App\Classes\Error;

class ApiError extends BaseError
{
    //資源驗證錯誤
    const INVALID_INPUT = 1;
    const INCORRECT_USERNAME_OR_PASSWORD = 2;
    const INVALID_USERNAME_FORMAT = 3;
    const INVALID_USER_PASSWORD_FORMAT = 4;

    //資源已存在
    const USERNAME_HAS_EXISTED = 11;

    //資源不存在
    const USER_NOT_FOUND = 21;

    //伺服器端錯誤
    const INTERNAL_SERVER_ERROR = 31;

    protected array $errorMessages = array(
        //資源驗證錯誤
        self::INVALID_INPUT => '無效的參數。',
        self::INCORRECT_USERNAME_OR_PASSWORD => 'Login Failed',
        self::INVALID_USERNAME_FORMAT => '無效的使用者名稱格式。',
        self::INVALID_USER_PASSWORD_FORMAT => '無效的使用者密碼格式。',

        //資源已存在
        self::USERNAME_HAS_EXISTED => '使用者名稱已存在。',

        //資源不存在
        self::USER_NOT_FOUND => '使用者不存在。',

        //伺服器端錯誤
        self::INTERNAL_SERVER_ERROR => '內部伺服器錯誤。',
    );

    /**
     * 轉為陣列
     *
     * @return array
     */
    public function toArray() : array
    {
        $content = array();
        $content['Code'] = $this->getCode();
        $content['Message'] = $this->getMessage();
        return $content;
    }
}
