<?php

declare(strict_types=1);

namespace Component\Product\Infrastructure\Repositories;

use Common\ValueObject\Currency;
use Common\ValueObject\Uuid;
use Component\Payment\Sdk\Model\Price;
use Component\Product\Domain\Repository\ProductRepository;
use Component\Product\Sdk\Model\Product;
use Illuminate\Support\Facades\DB;

class ProductRepositoryImpl implements ProductRepository
{
    private DB $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function all(): array
    {
        return $this->db::table('products')
            ->join('product_details', 'product_details.product_id', '=', 'products.id')
            ->leftJoin('user_products', 'user_products.product_id', '=', 'products.id')
            ->whereNull('user_products.product_id')
            ->select(
                'products.id',
                'products.amount',
                'products.currency',
                'product_details.name',
                'product_details.description',
                'product_details.image_url'
            )->get()
            ->map(function($product) {
                return new Product(
                    new Uuid($product->id),
                    $product->name,
                    $product->description,
                    new Price($product->amount, new Currency($product->currency)),
                    asset('assets/'.$product->image_url)
                );
            })->toArray();
    }
}
