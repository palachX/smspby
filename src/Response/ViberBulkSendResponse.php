<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Response;

use Vetheslav\SmspBy\Model\ApiError;
use Vetheslav\SmspBy\ValueObject\ViberBulkSendItem;

final class ViberBulkSendResponse extends AbstractResponse
{
    /**
     * @param ViberBulkSendItem[] $messages
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
            if (!\is_array($item)) {
                continue;
            }
            $messages[] = new ViberBulkSendItem(
                isset($item['message_id']) ? (int) $item['message_id'] : null,
                isset($item['price']) ? (float) $item['price'] : null,
                isset($item['custom_id']) ? (string) $item['custom_id'] : null,
            );
        }

        return new self($success, $error, $data, $messages);
    }

    /**
     * @return ViberBulkSendItem[]
     */
    public function messages(): array
    {
        return $this->messages;
    }
}
