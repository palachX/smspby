<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

final class SmsCostItem
{
    public function __construct(
        private readonly string $msisdn,
        private readonly ?float $pricePerPart,
        private readonly ?int $parts,
        private readonly ?float $amount,
    ) {
    }

    public function msisdn(): string
    {
        return $this->msisdn;
    }

    public function pricePerPart(): ?float
    {
        return $this->pricePerPart;
    }

    public function parts(): ?int
    {
        return $this->parts;
    }

    public function amount(): ?float
    {
        return $this->amount;
    }
}
