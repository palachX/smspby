<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

final class ViberSenderName
{
    /**
     * Creates a Viber sender name value object.
     * @param ViberTemplate[] $templates
     */
    public function __construct(
        private readonly string $sender,
        private readonly bool $isDefault,
        private readonly array $templates,
    ) {
    }

    /**
     * Returns the Viber sender name string approved for the account.
     */
    public function sender(): string
    {
        return $this->sender;
    }

    /**
     * Returns whether this Viber sender is marked as default.
     */
    public function isDefault(): bool
    {
        return $this->isDefault;
    }

    /**
     * Returns the list of Viber templates associated with this sender.
     * @return ViberTemplate[]
     */
    public function templates(): array
    {
        return $this->templates;
    }
}
