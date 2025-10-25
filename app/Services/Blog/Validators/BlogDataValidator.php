<?php

namespace App\Services\Blog\Validators;

use App\Contracts\IBaseDataValidator;
use App\Services\BaseServiceDataValidator;
use App\Support\Validation\ValidationResult;
use App\Traits\HttpRequestRules\BlogRules;

class BlogDataValidator extends BaseServiceDataValidator implements IBaseDataValidator
{
    use BlogRules;

    /**
     * @param array $data
     * @return ValidationResult
     * @throws \Exception
     */
    public function validateCreateData(array $data): ValidationResult
    {
        return $this->validateData($data, 'createRequestBlogRules');
    }

    /**
     * @param array $data
     * @return ValidationResult
     * @throws \Exception
     */
    public function validateGetData(array $data): ValidationResult
    {
        return $this->validateData($data, 'getRequestBlogRules');
    }

    /**
     * @param int $id
     * @param array $data
     * @return ValidationResult
     * @throws \Exception
     */
    public function validateUpdateData(int $id, array $data): ValidationResult
    {
        return $this->validateData($data, 'updateRequestBlogRules');
    }

    /**
     * @param int $id
     * @return ValidationResult
     * @throws \Exception
     */
    public function validateDeleteData(int $id): ValidationResult
    {
        return $this->validateData(['id' => $id], 'deleteRequestBlogRules');
    }
}
