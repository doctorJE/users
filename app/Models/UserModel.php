<?php

namespace App\Models;

use App\Classes\DatabaseHelper\QueryExecutor;
use App\Classes\ErrorHandling\ErrorHandleableReturnUser;
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

    /**
     * 更新密碼
     *
     * @param  User $user
     * @param  string $hashedPassword
     * @return ErrorHandleableReturnBoolean
     */
    public function updatePassword(User $user, string $hashedPassword) : ErrorHandleableReturnBoolean
    {
        $querySyntax = "
            UPDATE `user`
            SET    `password` = :password
            WHERE  `id` = :id";

        $bindingValues = array();
        $bindingValues['password'] = $hashedPassword;
        $bindingValues['id'] = $user->getId();

        $updateReturns = QueryExecutor::update($querySyntax, $bindingValues);
        if ($updateReturns->hasError()) {
            return new ErrorHandleableReturnBoolean(false, $updateReturns->getError());
        }

        $effectRows = $updateReturns->getValue();
        return new ErrorHandleableReturnBoolean($effectRows > 0);
    }

    /**
     * 透過帳號刪除使用者
     *
     * @param  User $user
     * @return ErrorHandleableReturnBoolean
     */
    public function deleteByAccount(User $user) : ErrorHandleableReturnBoolean
    {
        $querySyntax = '
            DELETE FROM `user`
            WHERE  `account` = :account';

        $bindingValues = array();
        $bindingValues['account'] = $user->getAccount();

        $deleteReturns = QueryExecutor::delete($querySyntax, $bindingValues);
        if ($deleteReturns->hasError()) {
            return new ErrorHandleableReturnBoolean(false, $deleteReturns->getError());
        }

        $effectRows = $deleteReturns->getValue();
        return new ErrorHandleableReturnBoolean($effectRows > 0);
    }

    /**
     * 透過帳號取得使用者
     *
     * @param  string $account
     * @return ErrorHandleableReturnUser
     */
    public function getByAccount(string $account) : ErrorHandleableReturnUser
    {
        $querySyntax = '
            SELECT *
            FROM   `user`
            WHERE  `account` = :account';

        $bindingValues = array();
        $bindingValues['account'] = $account;

        $selectedReturns = QueryExecutor::select($querySyntax, $bindingValues);
        if ($selectedReturns->hasError()) {
            return new ErrorHandleableReturnUser(new User(), $selectedReturns->getError());
        }

        $selectedValues = $selectedReturns->getValue();
        if (empty($selectedValues)) {
            return new ErrorHandleableReturnUser(new User(), new Error(Error::RESOURCE_NOT_FOUND));
        }

        $user = new User();
        $user->loadFromArray(array_shift($selectedValues));
        return new ErrorHandleableReturnUser($user);
    }
}
