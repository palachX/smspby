<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

final class StatusItem
{
    public function __construct(
        private readonly ?int $messageId,
        private readonly ?string $customId,
        private readonly MessageStatus $status,
    ) {
    }

    public function messageId(): ?int
    {
        return $this->messageId;
    }

    public function customId(): ?string
    {
        return $this->customId;
    }

    public function status(): MessageStatus
    {
        return $this->status;
    }
}
