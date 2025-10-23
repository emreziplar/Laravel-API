<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';
    protected $fillable = ['mediable_id', 'mediable_type', 'type', 'path'];

    public function mediable()
    {
        return $this->morphTo();
    }
}
