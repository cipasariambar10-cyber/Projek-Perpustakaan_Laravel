<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['nama', 'slug'];

    protected static function booted(): void
    {
        static::saving(function (Category $category) {
            if (empty($category->slug) && ! empty($category->nama)) {
                $category->slug = Str::slug($category->nama);
            }
        });
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
