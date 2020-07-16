<?php

namespace App\Http\Controllers\v1;

use App\Classes\Converter\OutputConverter;
use App\Classes\Error\ApiError;
use App\Classes\Error\Error;
use App\Classes\ResponseCreator;
use App\Classes\User;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Traits\ValidateRequest;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Classes\Exceptions\InvalidInputValueException;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    use ValidateRequest;

    /**
     * 建立使用者
     *
     * @return JsonResponse
     * @throws InvalidInputValueException
     */
    public function create() : JsonResponse
    {
        $this->requiredStringRangeFromInput('Account', 1, 50);
        $this->requiredStringRangeFromInput('Password', 1, 50);

        $account = Request::get('Account');
        $password = Request::get('Password');

        $userModel = new UserModel();
        $isAccountExistedReturns = $userModel->isAccountExisted($account);
        if ($isAccountExistedReturns->hasError()) {
            return ResponseCreator::createResponse(
                OutputConverter::convertResult(false, new ApiError(ApiError::INTERNAL_SERVER_ERROR))
                , Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
        if ($isAccountExistedReturns->getValue() == true) {
            return ResponseCreator::createResponse(
                OutputConverter::convertResult(false, new ApiError(ApiError::USERNAME_HAS_EXISTED))
                , Response::HTTP_CONFLICT
            );
        }

        $user = new User();
        $user->setAccount($account);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $createdUserReturns = $userModel->insert($user, $hashedPassword);
        if ($createdUserReturns->hasError()) {
            return ResponseCreator::createResponse(
                OutputConverter::convertResult(false, new ApiError(ApiError::INTERNAL_SERVER_ERROR))
                , Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return ResponseCreator::createResponse(
            OutputConverter::convertResult(true)
            , Response::HTTP_OK
        );
    }

    /**
     * 刪除使用者
     *
     * @return JsonResponse
     * @throws InvalidInputValueException
     */
    public function delete() : JsonResponse
    {
        $this->requiredStringRangeFromInput('Account', 1, 50);
        $account = Request::get('Account');

        $deleteUser = new User();
        $deleteUser->setAccount($account);

        $userModel = new UserModel();
        $deleteUserReturns = $userModel->deleteByAccount($deleteUser);
        if ($deleteUserReturns->hasError()) {
            return ResponseCreator::createResponse(
                OutputConverter::convertResult(false, new ApiError(ApiError::INTERNAL_SERVER_ERROR))
                , Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return ResponseCreator::createResponse(
            OutputConverter::convertResult(true)
            , Response::HTTP_OK
        );
    }

    /**
     * 變更使用者密碼
     *
     * @return JsonResponse
     * @throws InvalidInputValueException
     */
    public function changePassword() : JsonResponse
    {
        $this->requiredStringRangeFromInput('Account', 1, 50);
        $this->requiredStringRangeFromInput('Password', 1, 50);
        $account = Request::get('Account');
        $password = Request::get('Password');

        $userModel = new UserModel();
        $getExistedUserReturns = $userModel->getByAccount($account);
        if ($getExistedUserReturns->hasError()) {
            if ($getExistedUserReturns->getError()->getCode() == Error::RESOURCE_NOT_FOUND) {
                return ResponseCreator::createResponse(
                    OutputConverter::convertResult(false, new ApiError(ApiError::USER_NOT_FOUND))
                    , Response::HTTP_NOT_FOUND
                );
            }
            if ($getExistedUserReturns->getError()->getCode() == Error::DATABASE_ERROR) {
                return ResponseCreator::createResponse(
                    OutputConverter::convertResult(false, new ApiError(ApiError::INTERNAL_SERVER_ERROR))
                    , Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
        }
        $existedUser = $getExistedUserReturns->getValue();

        if ( ! $existedUser->isPasswordCorrect($password)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $updatePasswordReturns = $userModel->updatePassword($existedUser, $hashedPassword);
            if ($updatePasswordReturns->hasError()) {
                return ResponseCreator::createResponse(
                    OutputConverter::convertResult(false, new ApiError(ApiError::INTERNAL_SERVER_ERROR))
                    , Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
        }

        return ResponseCreator::createResponse(
            OutputConverter::convertResult(true)
            , Response::HTTP_OK
        );
    }
}
