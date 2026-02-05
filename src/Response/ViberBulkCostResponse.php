<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Response;

use Vetheslav\SmspBy\Model\ApiError;
use Vetheslav\SmspBy\ValueObject\ViberCostItem;

final class ViberBulkCostResponse extends AbstractResponse
{
    /**
     * @param ViberCostItem[] $messages
     */
    public function __construct(
        bool $success,
        ?ApiError $error,
        array $raw,
        private readonly array $messages,
    ) {
        parent::__construct($success, $error, $raw);
    }

    public static function fromArray(array $data): self
    {
        $success = ($data['status'] ?? true) !== false;
        $error = $success ? null : ApiError::fromMixed($data['error'] ?? null);

        $messages = [];
        foreach (($data['messages'] ?? []) as $item) {
            if (!\is_array($item) || !isset($item['msisdn'])) {
                continue;
            }
            $messages[] = new ViberCostItem(
                (string) $item['msisdn'],
                isset($item['price']) ? (float) $item['price'] : null,
            );
        }

        return new self($success, $error, $data, $messages);
    }

    /**
     * @return ViberCostItem[]
     */
    public function messages(): array
    {
        return $this->messages;
    }
}
