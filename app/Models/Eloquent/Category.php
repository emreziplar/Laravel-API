<?php

namespace App\Models\Eloquent;

use App\Models\Contracts\ICategoryModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Category extends Model implements ICategoryModel
{
    protected $table = 'categories';
    protected $fillable = ['parent_id', 'status'];

    public function toResourceArray(): array
    {
        return [
            'id' => $this->id,
            'names' => $this->translations?->pluck('name', 'lang_code'),
            'full_path' => $this->fullPath(),
            'parent' => $this->parent
                ? [
                    'id' => $this->parent->id,
                    'names' => $this->parent->translations?->pluck('name', 'lang_code')
                ]
                : []
        ];
    }

    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class, 'category_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function translation($lang_code = '')
    {
        $lang_code = $lang_code ?: App::getLocale();

        return $this->hasOne(CategoryTranslation::class, 'category_id')
            ->where('lang_code', $lang_code);
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function fullPath(): string
    {
        if (!$this->relationLoaded('translations') || !$this->relationLoaded('parent'))
            return 'Full path not loaded!';


        $locale = App::getLocale();

        $names = [];

        $category = $this;
        while ($category) {

            $translation = $category->translations->firstWhere('lang_code', $locale);

            if (!$translation) {
                $translation = $category->translations->firstWhere(
                    'lang_code',
                    config('app.fallback_locale', 'en')
                );
            }

            $names[] = $translation->name ?? '';
            $category = $category->parent;
        }

        $names = array_reverse($names);
        return implode(' > ', $names);
    }
}
