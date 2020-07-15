<?php

namespace App\Classes\ErrorHandling;

use App\Classes\Error\Error;

class ErrorHandleableReturnInteger extends ErrorHandleableReturnBase
{
    /**
     * ErrorHandleableReturnInteger constructor.
     *
     * @param int   $value
     * @param Error $error
     */
    public function __construct(int $value, Error $error = null)
    {
        parent::__construct($value, $error);
    }

    /**
     * 取得回傳值
     *
     * @return int
     */
    public function getValue() : int
    {
        return $this->value;
    }
}
