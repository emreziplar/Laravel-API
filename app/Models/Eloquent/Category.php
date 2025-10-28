<?php

namespace App\Models\Eloquent;

use App\Models\Contracts\ICategoryModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Category extends Model implements ICategoryModel
{
    protected $table = 'categories';
    protected $fillable = ['parent_id', 'status'];

    public function getId(): int
    {
        return $this->id;
    }

    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class, 'category_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function getFullPathAttribute(): string
    {
        return app(\App\Repositories\Contracts\Category\ICategoryRepository::class)
            ->getFullPath($this);
    }
}
