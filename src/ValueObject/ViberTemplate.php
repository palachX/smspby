<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

final class ViberTemplate
{
    /**
     * Creates a Viber template value object.
     */
    public function __construct(
        private readonly string $text,
        private readonly bool $active,
    ) {
    }

    /**
     * Returns the template text.
     */
    public function text(): string
    {
        return $this->text;
    }

    /**
     * Returns whether the template is active.
     */
    public function isActive(): bool
    {
        return $this->active;
    }
}
