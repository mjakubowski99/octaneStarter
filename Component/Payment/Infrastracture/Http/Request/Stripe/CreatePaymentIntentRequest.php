<?php

declare(strict_types=1);

namespace Component\Payment\Infrastracture\Http\Request\Stripe;

use App\Models\User;
use Common\ValueObject\PaymentMethod;
use Common\ValueObject\PaymentProvider;
use Common\ValueObject\Uuid;
use Component\Auth\Sdk\AuthFacade;
use Component\Payment\Sdk\Contract\CreateOrderContract;
use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentIntentRequest extends FormRequest implements CreateOrderContract
{
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'string'],
            'payment_methods' => ['required', 'array'],
            'payment_methods.*' => ['in:' . PaymentMethod::getAvailableForValidation()]
        ];
    }

    public function getProductId(): Uuid
    {
        /** @var string $productId */
        $productId = $this->input('product_id');

        return new Uuid($productId);
    }

    public function getBuyerId(): Uuid
    {
        return $this->buyerId;
    }

    public function getPaymentMethod(): PaymentMethod
    {
        /** @var string $paymentMethod */
        $paymentMethod = $this->input('payment_method');

        return new PaymentMethod($paymentMethod);
    }

    public function getPaymentProvider(): PaymentProvider
    {
        return PaymentProvider::stripe();
    }

    public function getPaymentMethods(): array
    {
        return $this->input('payment_methods');
    }
}
