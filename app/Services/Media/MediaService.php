<?php

namespace App\Services\Media;

use App\Contracts\Media\IMediaHandler;
use App\Contracts\Media\IMediaService;
use App\DTO\Request\Media\CreateMediaDTO;
use App\DTO\Response\ModelResponseDTO;
use App\Enums\ResourceType;
use App\Models\Contracts\IMediaModel;
use App\Repositories\Contracts\Media\IMediaRepository;
use App\Repositories\Proxy\RepositoryProxy;
use App\Support\Media\Media as MediaSupport;

class MediaService implements IMediaService
{
    protected IMediaRepository $mediaRepository;
    protected IMediaHandler $mediaHandler;
    protected RepositoryProxy $repositoryProxy;

    public function __construct(IMediaRepository $mediaRepository, IMediaHandler $mediaHandler, RepositoryProxy $repositoryProxy)
    {
        $this->mediaRepository = $mediaRepository;
        $this->mediaHandler = $mediaHandler;
        $this->repositoryProxy = $repositoryProxy;
    }

    public function create(CreateMediaDTO $createMediaDTO): ModelResponseDTO
    {
        $resourceType = $createMediaDTO->resourceType;
        $resourceName = $resourceType->value;
        $resourceId = $createMediaDTO->resourceId;
        $files = $createMediaDTO->files;

        $repository = $this->repositoryProxy->on($resourceType);

        $modelData = $repository->getFirst($resourceId);
        if (!$modelData)
            return new ModelResponseDTO(
                null,
                __t('media.resource_not_found', ['resource_name' => $resourceName]),
                404
            );

        //TODO: service validators // file jobs
        $mediaFields = [];
        foreach ($files as $file)
            $mediaFields[] = $this->mediaHandler->store($file, $resourceName);

        $mediaOfModel = $this->mediaRepository->createForModel($modelData, $mediaFields);

        return new ModelResponseDTO(
            $mediaOfModel ?: null,
            $mediaOfModel
                ? __t('media.resource_created', ['resource_name' => $resourceName])
                : __t('media.resource_not_created', ['resource_name' => $resourceName]),
            $mediaOfModel ? 200 : 500);
    }

    public function get(array $fields): ModelResponseDTO
    {
        $resourceName = $fields['resource_name'] ?? null;
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

    public function delete(int $id): ModelResponseDTO
    {
        /** @var IMediaModel $media */
        $media = $this->mediaRepository->getFirst($id);
        if (!$media)
            return new ModelResponseDTO(null, __t('media.not_found'), 404);

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
