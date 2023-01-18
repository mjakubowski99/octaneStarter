<?php

declare(strict_types=1);

namespace Component\Payment\Infrastracture\Repository;

use Common\ValueObject\Currency;
use Common\ValueObject\PaymentProvider;
use Common\ValueObject\Uuid;
use Component\Payment\Domain\Repository\ProductRepository;
use Component\Payment\Sdk\Exception\ProductNotFoundException;
use Component\Payment\Sdk\Model\Price;
use Illuminate\Support\Facades\DB;

class ProductRepositoryImpl implements ProductRepository
{
    private DB $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function getPrice(Uuid $productId): Price
    {
        $priceObject = $this->db::table('products')
            ->where('id', (string) $productId)
            ->select('amount', 'currency')
            ->first();

        if ($priceObject===null) {
            throw new ProductNotFoundException($productId);
        }

        return new Price(
            $priceObject->amount,
            new Currency($priceObject->currency)
        );
    }

    public function hasOwner(Uuid $productId): bool
    {
        return $this->db::table('user_products')
            ->where('product_id', $productId)
            ->exists();
    }

    public function getOwnerPaymentProviderAccountId(Uuid $productId, PaymentProvider $paymentProvider): string
    {
        return "";
    }
}
