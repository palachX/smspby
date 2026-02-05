<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

final class SmsCostMessage
{
    public function __construct(
        private readonly string $msisdn,
        private readonly string $text,
    ) {
        if ($this->msisdn === '') {
            throw new \InvalidArgumentException('msisdn must be a non-empty string.');
        }
        if ($this->text === '') {
            throw new \InvalidArgumentException('text must be a non-empty string.');
        }
    }

    public function toArray(): array
    {
        return [
            'msisdn' => $this->msisdn,
            'text' => $this->text,
        ];
    }
}
