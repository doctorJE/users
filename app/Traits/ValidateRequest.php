<?php

namespace App\Traits;

use App\Classes\Exceptions\InvalidInputValueException;
use Illuminate\Support\Facades\Request;

trait ValidateRequest
{
    /**
     * 要求Input內的指定變數爲合法長度範圍的字串
     *
     * @param  string $inputName
     * @param  int    $minimum
     * @param  int    $maximum
     * @throws InvalidInputValueException
     * @return void
     */
    public function requiredStringRangeFromInput(string $inputName, int $minimum, int $maximum)
    {
        if ( ! Request::has($inputName)) {
            throw new InvalidInputValueException();
        }

        $string = Request::input($inputName);

        if ( ! is_string($string)) {
            throw new InvalidInputValueException();
        }

        $stringLength = mb_strlen(trim($string), "utf-8");
        if ($stringLength < $minimum
            or $stringLength > $maximum) {
            throw new InvalidInputValueException();
        }
    }
}
