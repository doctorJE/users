<?php

namespace App\Classes\ErrorHandling;

use App\Classes\Error\Error;

abstract class ErrorHandleableReturnBase
{
    protected $value = null;
    protected ?Error $error = null;

    /**
     * ErrorHandleableReturnBase constructor.
     *
     * @param       $value
     * @param Error $error
     */
    public function __construct($value, Error $error = null)
    {
        $this->value = $value;
        $this->error = $error ?? new Error();
    }

    /**
     * 是否有錯誤
     *
     * @return bool
     */
    public function hasError() : bool
    {
        if ($this->error->getCode() == Error::NO_ERROR) {
            return false;
        }

        return true;
    }

    /**
     * 排除指定的錯誤之外，是否有錯誤
     *
     * @param  int[] ...$exceptedErrorCodes
     * @return bool
     */
    public function hasErrorExcept(int ...$exceptedErrorCodes) : bool
    {
        if ( ! $this->hasError()) {
            return false;
        }

        foreach ($exceptedErrorCodes as $exceptedErrorCode) {
            if ($this->error->getCode() == $exceptedErrorCode) {
                return false;
            }
        }

        return true;
    }

    /**
     * 取得錯誤
     *
     * @return Error
     */
    public function getError() : Error
    {
        return $this->error;
    }

    /**
     * 取得回傳值
     *
     * @return mixed
     */
    abstract public function getValue();
}
