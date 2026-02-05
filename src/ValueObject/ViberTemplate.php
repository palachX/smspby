<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

final class ViberTemplate
{
    public function __construct(
        private readonly string $text,
        private readonly bool $active,
    ) {
    }

    public function text(): string
    {
        return $this->text;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}
