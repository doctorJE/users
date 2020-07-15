<?php

namespace App\Classes\ErrorHandling;

use App\Classes\Error\Error;
use App\Classes\User;

class ErrorHandleableReturnUser extends ErrorHandleableReturnBase
{
    /**
     * ErrorHandleableReturnUser constructor.
     *
     * @param User  $user
     * @param Error $error
     */
    public function __construct(User $user, Error $error = null)
    {
        parent::__construct($user, $error);
    }

    /**
     * 取得回傳值
     *
     * @return User
     */
    public function getValue() : User
    {
        return $this->value;
    }
}
