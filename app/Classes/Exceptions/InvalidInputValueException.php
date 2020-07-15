<?php

namespace App\Classes\Exceptions;

use App\Classes\Error\ApiError;
use Exception;

class InvalidInputValueException extends Exception
{
    /**
     * InvalidInputValueException constructor.
     *
     * @param int $code
     */
    public function __construct(int $code = ApiError::INVALID_INPUT)
    {
        parent::__construct('', $code, null);
    }
}
