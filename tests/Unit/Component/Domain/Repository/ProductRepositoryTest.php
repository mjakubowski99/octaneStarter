<?php

namespace Tests\Unit\Component\Domain\Repository;

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

    public function test_hasOwner_ShouldReturnFalse_WhenInUserProductsTableDoesNotExistsRowRelatedToGivenProduct(): void
    {
        /** @var Product $product */
        $product = Product::factory()->create();

        $this->assertFalse($this->productRepository->hasOwner($product->getId()));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepository = $this->app->make(ProductRepository::class);
    }
}
