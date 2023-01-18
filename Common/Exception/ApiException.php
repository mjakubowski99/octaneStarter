<?php

declare(strict_types=1);

namespace Common\Exception;

use Illuminate\Contracts\Support\Arrayable;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiException extends HttpException implements Arrayable
{
    private array $metadata;

    public function __construct(string $message='', int $statusCode=400, array $metadata = [])
    {
        parent::__construct($statusCode, $message);
        $this->metadata = $metadata;
    }

    public function toArray(): array
    {
        return [
            'status' => $this->getStatusCode(),
            'message' => $this->getMessage(),
            'metadata' => $this->metadata
        ];
    }
}
