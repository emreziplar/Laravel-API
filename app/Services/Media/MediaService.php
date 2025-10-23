<?php

namespace App\Services\Media;

use App\Contracts\Media\IMediaHandler;
use App\Contracts\Media\IMediaService;
use App\DTO\Response\ModelResponseDTO;
use App\Repositories\Contracts\Media\IMediaRepository;
use App\Repositories\Proxy\RepositoryProxy;

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

    public function create(array $data): ModelResponseDTO
    {
        $repository = $this->repositoryProxy->for($data['resource_name']);

        $modelData = $repository->getFirst($data['resource_id']);
        if (!$modelData)
            return new ModelResponseDTO(null, __t('media.resource_not_found', ['resource_name' => $data['resource_name']]), 404);

        //TODO: service validators // file jobs
        $mediaFields = [];
        foreach ($data['files'] as $file)
            $mediaFields[] = $this->mediaHandler->store($file, $data['resource_name']);

        $mediaOfModel = $this->mediaRepository->createForModel($modelData, $mediaFields);

        return new ModelResponseDTO(
            $mediaOfModel ?: null,
            $mediaOfModel
                ? __t('media.resource_created', ['resource_name' => $data['resource_name']])
                : __t('media.resource_not_created', ['resource_name' => $data['resource_name']]),
            $mediaOfModel ? 200 : 500);
    }

    public function get(array $fields): ModelResponseDTO
    {
        // TODO: Implement get() method.
    }

    public function update(int $id, array $data): ModelResponseDTO
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id): ModelResponseDTO
    {
        // TODO: Implement delete() method.
    }
}
