<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

final class ViberSenderName
{
    /**
     * @param ViberTemplate[] $templates
     */
    public function __construct(
        private readonly string $sender,
        private readonly bool $isDefault,
        private readonly array $templates,
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

    /**
     * @return ViberTemplate[]
     */
    public function templates(): array
    {
        return $this->templates;
    }
}
