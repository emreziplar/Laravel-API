<?php

namespace App\Services\Media\Validators;


use App\Contracts\Media\IMediaBusinessValidator;
use App\DTO\Request\Media\CreateMediaDTO;
use App\Models\Contracts\IMediaModel;
use App\Models\Contracts\IUserModel;
use App\Repositories\Contracts\IBaseRepository;
use App\Repositories\Contracts\Media\IMediaRepository;
use App\Support\Validation\ValidationResult;

class MediaBusinessValidator implements IMediaBusinessValidator
{
    protected IMediaRepository $mediaRepository;

    public function __construct(IMediaRepository $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }

    public function validateForCreate(CreateMediaDTO $createMediaDTO, ?IBaseRepository $repository = null): ValidationResult
    {
        if (is_null($repository))
            return ValidationResult::fail('media.unsupported_action_repository', 501);

        if (!class_exists(get_class($repository)))
            return ValidationResult::fail('media.repository_not_found', 500);

        $modelData = $repository->getFirst($createMediaDTO->resourceId);
        if (!$modelData)
            return ValidationResult::fail(__t('media.resource_not_found', ['resource_name' => $createMediaDTO->resourceType->value]), 404);

        return ValidationResult::success([
            'model' => $modelData,
            'repository' => $repository
        ]);
    }

    public function validateForDelete(int $id, ?IUserModel $user = null): ValidationResult
    {
        /** @var IMediaModel $media */
        $media = $this->mediaRepository->getFirst($id);
        if (!$media)
            return ValidationResult::fail(__t('media.not_found'), 404);

        return ValidationResult::success([
            'media' => $media
        ]);
    }
}
