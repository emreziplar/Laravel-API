<?php

namespace App\Services\Blog\Validators;

use App\Contracts\Blog\IBlogDataValidator;
use App\Services\BaseServiceDataValidator;
use App\Support\Validation\ValidationResult;
use App\Traits\HttpRequestRules\BlogRules;

class BlogDataValidator extends BaseServiceDataValidator implements IBlogDataValidator
{
    use BlogRules;

    /**
     * @param array $data
     * @return ValidationResult
     * @throws \Exception
     */
    public function validateCreateData(array $data): ValidationResult
    {
        return $this->validateData($data, 'createBlogRequestRules');
    }

    /**
     * @param array $data
     * @return ValidationResult
     * @throws \Exception
     */
    public function validateGetData(array $data): ValidationResult
    {
        return $this->validateData($data, 'getBlogRequestRules');
    }

    /**
     * @param int $id
     * @param array $data
     * @return ValidationResult
     * @throws \Exception
     */
    public function validateUpdateData(int $id, array $data): ValidationResult
    {
        return $this->validateData($data, 'updateBlogRequestRules');
    }

    /**
     * @param int $id
     * @return ValidationResult
     * @throws \Exception
     */
    public function validateDeleteData(int $id): ValidationResult
    {
        return $this->validateData(['id' => $id], 'deleteBlogRequestRules');
    }
}
