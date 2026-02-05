<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Config;

final class Credentials
{
    public function __construct(
        private readonly string $user,
        private readonly string $apiKey,
    ) {
        if ($this->user === '' || $this->apiKey === '') {
            throw new \InvalidArgumentException('User and API key must be non-empty strings.');
        }
    }

    public function user(): string
    {
        return $this->user;
    }

    public function apiKey(): string
    {
        return $this->apiKey;
    }
}
