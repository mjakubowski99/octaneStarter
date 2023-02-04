<?php

declare(strict_types=1);

namespace Component\Product\Infrastructure\Entities;

use Database\Factories\ProductDetailFactory;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected static function newFactory(): ProductDetailFactory
    {
        return ProductDetailFactory::new();
    }
}
