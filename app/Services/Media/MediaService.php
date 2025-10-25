<?php

namespace App\Services\Media;

use App\Contracts\Media\IMediaBusinessValidator;
use App\Contracts\Media\IMediaDataValidator;
use App\Contracts\Media\IMediaHandler;
use App\Contracts\Media\IMediaService;
use App\DTO\Request\Media\CreateMediaDTO;
use App\DTO\Response\ModelResponseDTO;
use App\Enums\ResourceType;
use App\Models\Contracts\IMediaModel;
use App\Models\Contracts\IUserModel;
use App\Repositories\Contracts\Media\IMediaRepository;
use App\Repositories\Proxy\RepositoryProxy;
use App\Support\Media\Media as MediaSupport;

class MediaService implements IMediaService
{
    protected IMediaRepository $mediaRepository;
    protected IMediaHandler $mediaHandler;
    protected RepositoryProxy $repositoryProxy;
    protected IMediaDataValidator $dataValidator;
    protected IMediaBusinessValidator $businessValidator;

    public function __construct(IMediaRepository    $mediaRepository,
                                IMediaHandler       $mediaHandler,
                                RepositoryProxy     $repositoryProxy,
                                IMediaDataValidator $dataValidator, IMediaBusinessValidator $businessValidator)
    {
        $this->mediaRepository = $mediaRepository;
        $this->mediaHandler = $mediaHandler;
        $this->repositoryProxy = $repositoryProxy;
        $this->dataValidator = $dataValidator;
        $this->businessValidator = $businessValidator;
    }

    public function create(CreateMediaDTO $createMediaDTO, ?IUserModel $user = null): ModelResponseDTO
    {
        $dataValidation = $this->dataValidator->validateCreateData($createMediaDTO);
        if (!$dataValidation->isValid())
            return $dataValidation->toModelResponse();

        $resourceType = $createMediaDTO->resourceType;
        $resourceName = $resourceType->value;
        $files = $createMediaDTO->files;

        $repository = $this->repositoryProxy->on($resourceType);

        $businessValidation = $this->businessValidator->validateForCreate($createMediaDTO, $repository);
        if (!$businessValidation->isValid())
            return $businessValidation->toModelResponse();

        //TODO: file jobs
        $mediaFields = [];
        foreach ($files as $file)
            $mediaFields[] = $this->mediaHandler->store($file, $resourceName);

        $mediaOfModel = $this->mediaRepository->createForModel($businessValidation->get('model'), $mediaFields);

        return new ModelResponseDTO(
            $mediaOfModel ?: null,
            $mediaOfModel
                ? __t('media.resource_created', ['resource_name' => $resourceName])
                : __t('media.resource_not_created', ['resource_name' => $resourceName]),
            $mediaOfModel ? 200 : 500);
    }

    public function get(array $fields): ModelResponseDTO
    {
        $dataValidation = $this->dataValidator->validateGetData($fields);
        if (!$dataValidation->isValid())
            return $dataValidation->toModelResponse();

        $resourceName = $dataValidation->get('resource_name');

        if (!$resourceName) {
            $mediaData = $this->mediaRepository->all();
            $isMediaData = $mediaData->isNotEmpty();
            return new ModelResponseDTO(
                $isMediaData ? $mediaData : null,
                $isMediaData ? __t('media.found') : __t('media.not_found'),
                $isMediaData ? 200 : 404
            );
        }

        $resourceType = ResourceType::from($resourceName);
        $modelClass = $this->repositoryProxy->on($resourceType)->getModelClass();

        $data['mediable_type'] = $modelClass;
        $resourceId = $fields['resource_id'] ?? null;
        if ($resourceId)
            $data['mediable_id'] = $resourceId;

        $mediaData = $this->mediaRepository->getWithConditions($data);
        $isMediaData = $mediaData->isNotEmpty();
        return new ModelResponseDTO(
            $isMediaData ? $mediaData : null,
            $isMediaData ? __t('media.found') : __t('media.not_found'),
            $isMediaData ? 200 : 404
        );
    }

    public function delete(int $id, ?IUserModel $user = null): ModelResponseDTO
    {
        $dataValidation = $this->dataValidator->validateDeleteData($id);
        if (!$dataValidation->isValid())
            return $dataValidation->toModelResponse();


        $businessValidation = $this->businessValidator->validateForDelete($id, $user);
        if (!$businessValidation->isValid())
            return $businessValidation->toModelResponse();

        /** @var IMediaModel $media */
        $media = $businessValidation->get('media');

        $isDeleted = $this->mediaRepository->delete($media);

        //TODO: jobs
        if ($isDeleted)
            MediaSupport::deleteFile($media->getPath());

        return new ModelResponseDTO(
            $isDeleted ? null : $media,
            $isDeleted ? __t('media.deleted') : __t('media.not_deleted'),
            $isDeleted ? 200 : 500);
    }
}
