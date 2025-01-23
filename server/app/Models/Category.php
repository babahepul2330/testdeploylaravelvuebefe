<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        "name",
    ];

    public function scopeSearch(Builder $query, string $param)
    {
        $query->when($param, function ($query, $param) {
            return $query->whereRaw("LOWER(name) LIKE LOWER('%$param%')");
        });
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
