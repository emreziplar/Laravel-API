<?php

namespace App\Services;

use App\Support\Validation\ValidationResult;
use Illuminate\Support\Facades\Validator;

/**
 * General usage with http rules.
 * Custom validations can be performed on Services/Domain/Validators
 */
abstract class BaseServiceDataValidator
{
    protected function validateData($data, $methodName)
    {
        //do not validate if http request
        if (request()->route())
            return ValidationResult::success($data);

        if (!method_exists($this, $methodName))
            throw new \Exception("Method {$methodName} not found!");

        $validator = Validator::make($data, $this->{$methodName}());
        if ($validator->fails())
            return ValidationResult::fail($validator->errors()->messages(),422);

        return ValidationResult::success($data);
    }
}
