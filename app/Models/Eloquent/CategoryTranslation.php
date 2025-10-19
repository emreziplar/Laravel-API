<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    protected $table = 'category_translations';
    protected $fillable = ['category_id', 'name', 'slug', 'lang_code'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
