<?php

declare(strict_types=1);

namespace Component\Payment\Sdk\Stripe\Lib;

use Common\Exception\ApiException;
use Component\Payment\Sdk\Stripe\Event\StripeEvent;
use Component\Payment\Sdk\Stripe\Event\StripeEventImpl;
use Component\Payment\Sdk\Stripe\Intent\StripePaymentIntent;
use Component\Payment\Sdk\Stripe\ValueObject\Status;
use Illuminate\Support\Facades\Session;
use Stripe\Account;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Exception\UnexpectedValueException;
use Stripe\Webhook;
use Stripe\StripeClient;
use Stripe\Exception\ApiErrorException;
use Illuminate\Contracts\Config\Repository as Config;

class StripeImpl implements Stripe
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /** @throws ApiErrorException **/
    public function createPaymentIntent(array $data, array $opts): StripePaymentIntent
    {
        $client = new StripeClient($this->config->get('services.stripe.api_key'));

        $paymentIntent = $client->paymentIntents->create($data, empty($opts) ? null : $opts);

        if ($paymentIntent->on_behalf_of instanceof Account) {
            $accountId = $paymentIntent->on_behalf_of->id;
        } else {
            $accountId = $paymentIntent->on_behalf_of;
        }

        return new StripePaymentIntent(
            $paymentIntent->id,
            $this->config->get('services.stripe.publishable_key'),
            $paymentIntent->client_secret,
            new Status($paymentIntent->status),
            $accountId
        );
    }

    public function constructWebhookEvent(string $requestContent, string $httpSignature): StripeEvent
    {
        \Stripe\Stripe::setApiKey($this->config->get('services.stripe.api_key'));

        try {
            return $this->tryToMakeWebhookEvent($requestContent, $httpSignature);
        } catch (UnexpectedValueException | SignatureVerificationException $exception) {
            throw new ApiException($exception->getMessage(), 400);
        }
    }

    /**
     * @throws UnexpectedValueException
     * @throws SignatureVerificationException
     */
    private function tryToMakeWebhookEvent(string $requestContent, string $httpSignature): StripeEvent
    {
        try {
            $event = Webhook::constructEvent(
                $requestContent,
                $httpSignature,
                $this->config->get('services.stripe.webhook_secret')
            );
            $isConnectEvent = false;
        } catch (SignatureVerificationException $exception) {
            $event = Webhook::constructEvent(
                $requestContent,
                $httpSignature,
                $this->config->get('services.stripe.connect_webhook_secret')
            );
            $isConnectEvent = true;
        }

        return new StripeEventImpl($event, $isConnectEvent);
    }
}
