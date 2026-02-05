<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

final class ViberCostItem
{
    public function __construct(
        private readonly string $msisdn,
        private readonly ?float $price,
    ) {
    }

    public function msisdn(): string
    {
        return $this->msisdn;
    }

    public function price(): ?float
    {
        return $this->price;
    }
}
