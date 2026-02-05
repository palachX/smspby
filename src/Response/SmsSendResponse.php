<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Response;

use Vetheslav\SmspBy\Model\ApiError;

final class SmsSendResponse extends AbstractResponse
{
    public function __construct(
        bool $success,
        ?ApiError $error,
        array $raw,
        private readonly ?int $messageId,
        private readonly ?float $pricePerPart,
        private readonly ?int $parts,
        private readonly ?float $amount,
        private readonly ?string $customId,
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
            isset($data['message_id']) ? (int) $data['message_id'] : null,
            isset($data['price']) ? (float) $data['price'] : null,
            isset($data['parts']) ? (int) $data['parts'] : null,
            isset($data['amount']) ? (float) $data['amount'] : null,
            isset($data['custom_id']) ? (string) $data['custom_id'] : null,
        );
    }

    public function messageId(): ?int
    {
        return $this->messageId;
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

    public function customId(): ?string
    {
        return $this->customId;
    }
}
