<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

final class Template
{
    /**
     * Creates a template value object.
     */
    public function __construct(
        private readonly int $templateId,
        private readonly string $name,
        private readonly string $text,
    ) {
    }

    /**
     * Returns the template ID assigned by the platform.
     */
    public function templateId(): int
    {
        return $this->templateId;
    }

    /**
     * Returns the template name.
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Returns the template text.
     */
    public function text(): string
    {
        return $this->text;
    }
}
