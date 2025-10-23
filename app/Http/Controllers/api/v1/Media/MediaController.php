<?php

namespace App\Http\Controllers\api\v1\Media;

use App\Contracts\Media\IMediaService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\CreateMediaRequest;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    protected const POLICY = 'mediaPolicy';
    protected IMediaService $mediaService;

    public function __construct(IMediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function createMedia(CreateMediaRequest $createMediaRequest)
    {
        $this->authorize('create',self::POLICY);

        $mediaDTO = $this->mediaService->create($createMediaRequest->validated());

        //TODO: resource resolver + url
        return $this->respondWithModelDTO($mediaDTO);
    }


}
