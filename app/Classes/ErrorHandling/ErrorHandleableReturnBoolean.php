<?php

namespace App\Classes\ErrorHandling;

use App\Classes\Error\Error;

class ErrorHandleableReturnBoolean extends ErrorHandleableReturnBase
{
    /**
     * ErrorHandleableReturnBoolean constructor.
     *
     * @param bool  $value
     * @param Error $error
     */
    public function __construct(bool $value, Error $error = null)
    {
        parent::__construct($value, $error);
    }

    /**
     * 取得回傳值
     *
     * @return bool
     */
    public function getValue() : bool
    {
        return $this->value;
    }
}
