<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'description',
    ];

    //1 kategori memiliki banyak produk
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
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
}
