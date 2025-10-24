<?php

namespace App\Http\Controllers\api\v1\Media;

use App\Contracts\Media\IMediaService;
use App\DTO\Request\Media\CreateMediaDTO;
use App\Enums\ResourceType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\CreateMediaRequest;
use App\Http\Requests\Media\DeleteMediaRequest;
use App\Http\Requests\Media\GetMediaRequest;
use App\Http\Resources\Media\MediaResource;
use App\Http\Resources\ResourceProxy;
use Dedoc\Scramble\Attributes\Endpoint;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    protected const POLICY = 'mediaPolicy';
    protected IMediaService $mediaService;
    protected ResourceProxy $resourceProxy;

    public function __construct(IMediaService $mediaService, ResourceProxy $resourceProxy)
    {
        $this->mediaService = $mediaService;
        $this->resourceProxy = $resourceProxy;
    }

    #[Endpoint('Create Media')]
    public function createMedia(CreateMediaRequest $createMediaRequest)
    {
        $this->authorize('create', self::POLICY);

        $reqData = $createMediaRequest->validated();

        $resourceType = ResourceType::from($reqData['resource_name']);

        $createMediaDTO = new CreateMediaDTO(
            resourceType: $resourceType,
            resourceId: $reqData['resource_id'],
            files: $reqData['files']
        );

        $modelDTO = $this->mediaService->create($createMediaDTO);

        return $this->respondWithModelDTO($modelDTO, $this->resourceProxy->on($resourceType));
    }

    #[Endpoint('Get Media')]
    public function getMedia(GetMediaRequest $getMediaRequest)
    {
        $this->authorize('get', self::POLICY);

        $responseDTO = $this->mediaService->get($getMediaRequest->validated());

        return $this->respondWithModelDTO($responseDTO, MediaResource::class);
    }

    #[Endpoint('Delete Media')]
    public function deleteMedia(DeleteMediaRequest $deleteMediaRequest)
    {
        $this->authorize('delete', self::POLICY);

        $reqData = $deleteMediaRequest->validated();
        $responseDTO = $this->mediaService->delete($reqData['id']);

        return $this->respondWithModelDTO($responseDTO, MediaResource::class);
    }
}
