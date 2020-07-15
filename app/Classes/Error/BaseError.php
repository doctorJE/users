<?php

namespace App\Classes\Error;

abstract class BaseError
{
    const NO_ERROR = 0;

    private int $code = 0;
    private string $message = '';

    protected array $errorMessages = array();

    /**
     * BaseError constructor.
     *
     * @param int    $code
     * @param string $customMessage
     */
    public function __construct(int $code = BaseError::NO_ERROR, string $customMessage = '')
    {
        $this->setCode($code);
        if ($customMessage != '') {
            $this->message = $customMessage;
        }
    }

    /**
     * 設定錯誤編號
     *
     * @param int $code
     * @return void
     */
    public function setCode(int $code)
    {
        if (isset($this->errorMessages[$code])) {
            $this->code = $code;
            $this->message = $this->errorMessages[$code];
        }
    }

    /**
     * 取得錯誤編號
     *
     * @return int
     */
    public function getCode() : int
    {
        return $this->code;
    }

    /**
     * 取得錯誤訊息
     *
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }
}
