<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

final class ViberBulkSendItem
{
    public function __construct(
        private readonly ?int $messageId,
        private readonly ?float $price,
        private readonly ?string $customId,
    ) {
    }

    public function messageId(): ?int
    {
        return $this->messageId;
    }

    public function price(): ?float
    {
        return $this->price;
    }

    public function customId(): ?string
    {
        return $this->customId;
    }
}
