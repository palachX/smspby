<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

final class Template
{
    public function __construct(
        private readonly int $templateId,
        private readonly string $name,
        private readonly string $text,
    ) {
    }

    public function templateId(): int
    {
        return $this->templateId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function text(): string
    {
        return $this->text;
    }
}
