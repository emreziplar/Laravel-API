<?php

namespace App\Models\Eloquent;

use App\Models\Contracts\IMediaModel;
use Illuminate\Database\Eloquent\Model;

class Media extends Model implements IMediaModel
{
    protected $table = 'media';
    protected $fillable = ['mediable_id', 'mediable_type', 'type', 'path'];

    public function mediable()
    {
        return $this->morphTo();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMediableType(): string
    {
        return strtolower(last(explode('\\', $this->mediable_type)));
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
