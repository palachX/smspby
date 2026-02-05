<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

final class SmsSenderName
{
    public function __construct(
        private readonly string $sender,
        private readonly bool $isDefault,
    ) {
    }

    public function sender(): string
    {
        return $this->sender;
    }

    public function isDefault(): bool
    {
        return $this->isDefault;
    }
}
