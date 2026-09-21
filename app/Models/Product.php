<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'price',
        'stock_quantity',
        'image_path',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
            'stock_quantity' => 'integer',
        ];
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (!empty($this->image_path)) {
            return $this->image_path;
        }

        $name = strtolower($this->name);
        $category = strtolower($this->category);

        if (str_contains($name, 'food') || str_contains($name, 'kibble') || str_contains($name, 'feast') || $category === 'food') {
            return '/images/dog-food.jpg';
        }
        if (str_contains($name, 'litter') || str_contains($name, 'dental') || str_contains($name, 'stain') || str_contains($name, 'balm') || $category === 'care') {
            return '/images/cat-litter.jpg';
        }
        if (str_contains($name, 'shampoo') || str_contains($name, 'rake') || str_contains($name, 'spray') || $category === 'grooming') {
            return '/images/pet-shampoo.jpg';
        }
        if (str_contains($name, 'toy') || str_contains($name, 'rope') || str_contains($name, 'puzzle') || str_contains($name, 'duck') || str_contains($name, 'wand') || $category === 'toys') {
            return '/images/dog-toys.jpg';
        }
        if (str_contains($name, 'wellness') || str_contains($name, 'supplement') || str_contains($name, 'chews') || str_contains($name, 'tablets') || str_contains($name, 'powder') || $category === 'wellness') {
            return '/images/care-tips.jpg';
        }

        return '/images/dog-food.jpg';
    }
}
