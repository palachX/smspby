<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Response;

use Vetheslav\SmspBy\Model\ApiError;
use Vetheslav\SmspBy\ValueObject\MessageStatus;
use Vetheslav\SmspBy\ValueObject\MessageChannel;

final class StatusResponse extends AbstractResponse
{
    public function __construct(
        bool $success,
        ?ApiError $error,
        array $raw,
        private readonly MessageStatus $messageStatus,
    ) {
        parent::__construct($success, $error, $raw);
    }

    public static function fromArray(array $data): self
    {
        return self::fromSmsArray($data);
    }

    public static function fromSmsArray(array $data): self
    {
        return self::fromArrayForChannel($data, MessageChannel::Sms);
    }

    public static function fromViberArray(array $data): self
    {
        return self::fromArrayForChannel($data, MessageChannel::Viber);
    }

    private static function fromArrayForChannel(array $data, MessageChannel $channel): self
    {
        $success = ($data['status'] ?? true) !== false;
        $error = $success ? null : ApiError::fromMixed($data['error'] ?? null);

        $statusData = \is_array($data['message_status'] ?? null) ? $data['message_status'] : [];
        $code = $statusData['code'] ?? null;
        $name = isset($statusData['name']) ? (string) $statusData['name'] : null;

        $messageStatus = match ($channel) {
            MessageChannel::Viber => MessageStatus::fromViberCode($code, $name),
            MessageChannel::Sms => MessageStatus::fromSmsCode($code, $name),
        };

        return new self($success, $error, $data, $messageStatus);
    }

    public function messageStatus(): MessageStatus
    {
        return $this->messageStatus;
    }
}
