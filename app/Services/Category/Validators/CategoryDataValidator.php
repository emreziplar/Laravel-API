<?php

namespace App\Services\Category\Validators;

use App\Contracts\Category\ICategoryDataValidator;
use App\Services\BaseServiceDataValidator;
use App\Support\Validation\ValidationResult;
use App\Traits\HttpRequestRules\CategoryRules;

class CategoryDataValidator extends BaseServiceDataValidator implements ICategoryDataValidator
{
    use CategoryRules;

    /**
     * @param array $data
     * @return ValidationResult
     * @throws \Exception
     */
    public function validateCreateData(array $data): ValidationResult
    {
        return $this->validateData($data, 'createCategoryRequestRules');
    }

    /**
     * @param array $data
     * @return ValidationResult
     * @throws \Exception
     */
    public function validateGetData(array $data): ValidationResult
    {
        return $this->validateData($data, 'getCategoryRequestRules');
    }

    /**
     * @param int $id
     * @param array $data
     * @return ValidationResult
     * @throws \Exception
     */
    public function validateUpdateData(int $id, array $data): ValidationResult
    {
        return $this->validateData($data, 'updateCategoryRequestRules');
    }

    /**
     * @param int $id
     * @return ValidationResult
     * @throws \Exception
     */
    public function validateDeleteData(int $id): ValidationResult
    {
        return $this->validateData(['id' => $id], 'deleteCategoryRequestRules');
    }
}
