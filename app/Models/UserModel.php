<?php

namespace App\Models;

use App\Classes\DatabaseHelper\QueryExecutor;
use App\Classes\User;
use App\Classes\Error\Error;
use App\Classes\ErrorHandling\ErrorHandleableReturnBoolean;

class UserModel
{
    /**
     * 新增
     *
     * @param  User $user
     * @param  string $hashedPassword
     * @return ErrorHandleableReturnBoolean
     */
    public function insert(User $user, string $hashedPassword) : ErrorHandleableReturnBoolean
    {
        $querySyntax = '
            INSERT INTO `user`
                (`account`, `password`)
            VALUES
                (:account, :hashedPassword)';

        $bindingValues = array();
        $bindingValues['account'] = $user->getAccount();
        $bindingValues['hashedPassword'] = $hashedPassword;

        $insertResult = QueryExecutor::insert($querySyntax, $bindingValues);
        if ($insertResult->hasError()) {
            return new ErrorHandleableReturnBoolean(false, $insertResult->getError());
        }

        $isInserted = $insertResult->getValue();
        if ( ! $isInserted) {
            return new ErrorHandleableReturnBoolean(false, new Error(Error::RESOURCE_ESTABLISH_FAILED));
        }

        return new ErrorHandleableReturnBoolean(true);
    }
}
