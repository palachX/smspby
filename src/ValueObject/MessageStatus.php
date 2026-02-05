<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

final class MessageStatus
{
    /**
     * Creates a delivery status wrapper for SMS/Viber.
     */
    public function __construct(
        private readonly SmsMessageStatus|ViberMessageStatus|null $code,
        private readonly ?string $name,
    ) {
    }

    /**
     * Returns the delivery status enum (SMS or Viber), or null if unavailable.
     */
    public function code(): SmsMessageStatus|ViberMessageStatus|null
    {
        return $this->code;
    }

    /**
     * Returns the human-readable status label from the API.
     */
    public function name(): ?string
    {
        return $this->name;
    }

    /**
     * Creates a MessageStatus from a raw SMS status code.
     */
    public static function fromSmsCode(int|false|null $code, ?string $name): self
    {
        return new self(self::smsStatusFromCode($code), $name);
    }

    /**
     * Creates a MessageStatus from a raw Viber status code.
     */
    public static function fromViberCode(int|false|null $code, ?string $name): self
    {
        return new self(self::viberStatusFromCode($code), $name);
    }

    private static function smsStatusFromCode(int|false|null $code): ?SmsMessageStatus
    {
        if ($code === null || $code === false) {
            return null;
        }

        return SmsMessageStatus::tryFrom((int) $code);
    }

    private static function viberStatusFromCode(int|false|null $code): ?ViberMessageStatus
    {
        if ($code === null || $code === false) {
            return null;
        }

        return ViberMessageStatus::tryFrom((int) $code);
    }
}
