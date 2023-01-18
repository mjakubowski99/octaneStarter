<?php

declare(strict_types=1);

namespace Tests\Feature\Component\Domain\Repository;

use Component\Payment\Domain\Repository\ProductRepository;
use Component\Payment\Infrastracture\Entities\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private ProductRepository $productRepository;

    public function test_GetPrice_ShouldReturnProductPrice(): void
    {
        /** @var Product $product */
        $product = Product::factory()->create();

        $actualPrice = $this->productRepository->getPrice($product->getId());

        $this->assertTrue($product->getPrice()->equals($actualPrice));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepository = $this->app->make(ProductRepository::class);
    }
}
