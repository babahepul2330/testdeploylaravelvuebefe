<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Order extends Pivot
{
    use HasFactory, HasUuids;

    protected $table = "orders";

    protected $fillable = [
        'user_id',
        'product_id',
        "order_id",
        "first_name",
        "last_name",
        "address",
        "price",
        "total_price",
        "quantity",
        "status",
    ];

    public function scopeSearch(Builder $query, string $param)
    {
        $query->when($param, function ($query, $param) {
            return $query->whereRaw("LOWER(first_name) LIKE LOWER('%$param%')")
                ->orWhereRaw("LOWER(last_name) LIKE LOWER('%$param%')");
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
