<?php

namespace App\Models\Eloquent;

use App\Models\Contracts\IBlogModel;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model implements IBlogModel
{
    protected $table = 'blogs';
    protected $fillable = ['category_id', 'status'];

    public function getId(): int
    {
        return $this->id;
    }

    public function translations()
    {
        return $this->hasMany(BlogTranslation::class, 'blog_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
