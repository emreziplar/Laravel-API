<?php

namespace App\Http\Resources\Media;

use App\Models\Contracts\IMediaModel;
use App\Support\Media\Media as MediaSupport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin IMediaModel
 */
class ModelMediaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'type' => $this->type,
            'path' => MediaSupport::getStoragePublicUrl() . $this->path,
        ];
    }
}
