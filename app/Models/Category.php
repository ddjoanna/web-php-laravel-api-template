<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'parent_id',
        'layer',
        'sort_order',
        'is_active',
    ];

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->orderBy('sort_order', 'asc');
    }
}
