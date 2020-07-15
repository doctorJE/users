<?php

namespace App\Http\Controllers;

use App\Classes\Converter\OutputConverter;
use App\Classes\Error\ApiError;
use App\Classes\Exceptions\InvalidInputValueException;
use App\Classes\ResponseCreator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Execute an action on the controller.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function callAction($method, $parameters)
    {
        try {
            return parent::callAction($method, $parameters);
        } catch (InvalidInputValueException $exception) {
            return ResponseCreator::createResponse(
                OutputConverter::convertResult(false, new ApiError($exception->getCode()))
                , Response::HTTP_BAD_REQUEST
            );
        }
    }
}
