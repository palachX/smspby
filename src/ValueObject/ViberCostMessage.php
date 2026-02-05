<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

final class ViberCostMessage
{
    public function __construct(
        private readonly string $msisdn,
        private readonly ViberMessageType $type,
    ) {
        if ($this->msisdn === '') {
            throw new \InvalidArgumentException('msisdn must be a non-empty string.');
        }
    }

    public function toArray(): array
    {
        return [
            'msisdn' => $this->msisdn,
            'type' => $this->type->value,
        ];
    }
}
