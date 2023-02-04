<?php

declare(strict_types=1);

namespace Component\Product\Domain\Repository;

use Component\Product\Sdk\Model\Product;

interface ProductRepository
{
    /** @return Product[] */
    public function all(): array;
}
