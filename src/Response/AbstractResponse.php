<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Response;

use Vetheslav\SmspBy\Model\ApiError;

abstract class AbstractResponse
{
    public function __construct(
        private readonly bool $success,
        private readonly ?ApiError $error,
        private readonly array $raw,
    ) {
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function error(): ?ApiError
    {
        return $this->error;
    }

    public function raw(): array
    {
        return $this->raw;
    }
}
