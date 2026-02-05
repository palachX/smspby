<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

final class StatusItem
{
    /**
     * Creates a status item for bulk status responses.
     */
    public function __construct(
        private readonly ?int $messageId,
        private readonly ?string $customId,
        private readonly MessageStatus $status,
    ) {
    }

    /**
     * Returns the platform message ID for this status item, if available.
     */
    public function messageId(): ?int
    {
        return $this->messageId;
    }

    /**
     * Returns the custom_id for this status item, if provided.
     */
    public function customId(): ?string
    {
        return $this->customId;
    }

    /**
     * Returns the parsed delivery status for this item.
     */
    public function status(): MessageStatus
    {
        return $this->status;
    }
}
