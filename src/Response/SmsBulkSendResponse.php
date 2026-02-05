<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Response;

use Vetheslav\SmspBy\Model\ApiError;

final class SmsBulkSendResponse extends AbstractResponse
{
    /**
     * @param SmsSendResponse[] $messages
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
            $item['status'] = true;
            $messages[] = SmsSendResponse::fromArray($item);
        }

        return new self($success, $error, $data, $messages);
    }

    public function messages(): array
    {
        return $this->messages;
    }
}
