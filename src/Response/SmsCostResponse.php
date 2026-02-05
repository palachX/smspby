<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Response;

use Vetheslav\SmspBy\Model\ApiError;

final class SmsCostResponse extends AbstractResponse
{
    public function __construct(
        bool $success,
        ?ApiError $error,
        array $raw,
        private readonly ?float $pricePerPart,
        private readonly ?int $parts,
        private readonly ?float $amount,
    ) {
        parent::__construct($success, $error, $raw);
    }

    public static function fromArray(array $data): self
    {
        $success = ($data['status'] ?? true) !== false;
        $error = $success ? null : ApiError::fromMixed($data['error'] ?? null);

        return new self(
            $success,
            $error,
            $data,
            isset($data['price']) ? (float) $data['price'] : null,
            isset($data['parts']) ? (int) $data['parts'] : null,
            isset($data['amount']) ? (float) $data['amount'] : null,
        );
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
