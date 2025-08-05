<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
            'name',
            'slug',
            'category_id',
            'stock',
            'price',
            'is_active',
            'image',
            'barcode',
            'description',
    ];

    //1 produk hanya punya 1 kategori
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public static function generateUniqueSlug(string $name): string
    {
        //Jika ada slug yang sama, maka akan ada counter di belakangnya
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;

    }

    public function getImageUrlAttribute()
    {
        return $this->image ? url('storage/'. $this->image) : null;
    }

    public function scopeSearch($query, $value)
    {
        $query->where("name", "like", "%{$value}%");
    }
}
