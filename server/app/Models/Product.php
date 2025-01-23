<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'description',
        'image',
        'image_public_id',
        'stock',
    ];

    public function scopeSearch(Builder $query, string $param)
    {
        $query->when($param, function ($query, $param) {
            return $query->whereRaw("LOWER(name) LIKE LOWER('%$param%')");
        });
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'orders', 'product_id', 'user_id')
            ->withPivot([
                'user_id',
                'product_id',
                "order_id",
                "first_name",
                "last_name",
                "address",
                "total_price",
                "quantity",
                "status",
            ]);
    }
}
