<?php

namespace App\Services\Media\Validators;

use App\Contracts\Media\IMediaDataValidator;
use App\DTO\Request\Media\CreateMediaDTO;
use App\Services\BaseServiceDataValidator;
use App\Support\Validation\ValidationResult;
use App\Traits\HttpRequestRules\MediaRules;

class MediaDataValidator extends BaseServiceDataValidator implements IMediaDataValidator
{
    use MediaRules;

    /**
     * @param CreateMediaDTO $createMediaDTO
     * @return ValidationResult
     * @throws \Exception
     */
    public function validateCreateData(CreateMediaDTO $createMediaDTO): ValidationResult
    {
        $data = [
            'resource_name' => $createMediaDTO->resourceType->value,
            'resource_id' => $createMediaDTO->resourceId,
            'files' => $createMediaDTO->files
        ];
        return $this->validateData($data, 'createMediaRequestRules');
    }

    /**
     * @param array $data
     * @return ValidationResult
     * @throws \Exception
     */
    public function validateGetData(array $data): ValidationResult
    {
        return $this->validateData($data, 'getMediaRequestRules');
    }

    /**
     * @param int $id
     * @return ValidationResult
     * @throws \Exception
     */
    public function validateDeleteData(int $id): ValidationResult
    {
        return $this->validateData(['id' => $id], 'deleteMediaRequestRules');
    }
}
