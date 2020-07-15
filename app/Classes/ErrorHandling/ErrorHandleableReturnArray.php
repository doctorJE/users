<?php

namespace App\Classes\ErrorHandling;

use App\Classes\Error\Error;

class ErrorHandleableReturnArray extends ErrorHandleableReturnBase
{
    /**
     * ErrorHandleableReturnArray constructor.
     *
     * @param array $value
     * @param Error $error
     */
    public function __construct(array $value, Error $error = null)
    {
        parent::__construct($value, $error);
    }

    /**
     * 取得回傳值
     *
     * @return array
     */
    public function getValue() : array
    {
        return $this->value;
    }
}
