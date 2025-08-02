<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    //1 produk hanya punya 1 kategori
    public function category(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
