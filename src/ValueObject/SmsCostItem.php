<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

final class SmsCostItem
{
    /**
     * Creates a cost item for an SMS message.
     */
    public function __construct(
        private readonly string $msisdn,
        private readonly ?float $pricePerPart,
        private readonly ?int $parts,
        private readonly ?float $amount,
    ) {
    }

    /**
     * Returns the recipient MSISDN for this cost item.
     */
    public function msisdn(): string
    {
        return $this->msisdn;
    }

    /**
     * Returns the price per part for this cost item.
     */
    public function pricePerPart(): ?float
    {
        return $this->pricePerPart;
    }

    /**
     * Returns the number of SMS parts for this cost item.
     */
    public function parts(): ?int
    {
        return $this->parts;
    }

    /**
     * Returns the total cost for this cost item.
     */
    public function amount(): ?float
    {
        return $this->amount;
    }
}
