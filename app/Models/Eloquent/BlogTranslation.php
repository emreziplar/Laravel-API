<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class BlogTranslation extends Model
{
    protected $table = 'blog_translations';
    protected $fillable = ['blog_id', 'author_id', 'title', 'slug', 'content', 'lang_code'];

}
