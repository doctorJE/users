<?php

namespace App\Classes;

class User
{
    private int    $id;
    private string $account;
    private string $hashedPassword;

    /**
     * 設定編號
     *
     * @param  int $id
     * @return void
     */
    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    /**
     * 取得編號
     *
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * 設定帳號
     *
     * @param  string $account
     * @return void
     */
    public function setAccount(string $account) : void
    {
        $this->account = $account;
    }

    /**
     * 取得帳號
     *
     * @return string
     */
    public function getAccount() : string
    {
        return $this->account;
    }

    /**
     * 設定 Bcrypt 雜湊的密碼
     *
     * @param  string $hashedPassword
     * @return void
     */
    public function setHashedPassword(string $hashedPassword) : void
    {
        $this->hashedPassword = $hashedPassword;
    }

    /**
     * 檢查密碼是否正確
     *
     * @param  string $password
     * @return bool
     */
    public function isPasswordCorrect(string $password) : bool
    {
        return password_verify($password, $this->hashedPassword);
    }

    /**
     * 載入陣列
     *
     * @param  array $information
     * @return void
     */
    public function loadFromArray(array $information) : void
    {
        if (isset($information['id'])) {
            $this->setId($information['id']);
        }
        if (isset($information['account'])) {
            $this->setAccount($information['account']);
        }
        if (isset($information['password'])) {
            $this->setHashedPassword($information['password']);
        }
    }

    /**
     * 匯出陣列
     *
     * @return array
     */
    public function toArray() : array
    {
        $content = array();
        $content['id'] = $this->getId();
        $content['account'] = $this->getAccount();

        return $content;
    }
}
