<?php

namespace App\Models\Eloquent;

use App\Models\Contracts\IBlogTranslationModel;
use Illuminate\Database\Eloquent\Model;

class BlogTranslation extends Model implements IBlogTranslationModel
{
    protected $table = 'blog_translations';
    protected $fillable = ['blog_id', 'author_id', 'title', 'slug', 'content', 'lang_code'];

    public function getId(): int
    {
        return $this->id;
    }

    public function author()
    {
        return $this->belongsTo(User::class,'author_id');
    }
}
