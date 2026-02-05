<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Response;

use Vetheslav\SmspBy\Model\ApiError;

final class BalanceResponse extends AbstractResponse
{
    public function __construct(
        bool $success,
        ?ApiError $error,
        array $raw,
        private readonly ?float $smsBalance,
        private readonly ?float $viberBalance,
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
            isset($data['sms']) ? (float) $data['sms'] : null,
            isset($data['viber']) ? (float) $data['viber'] : null,
        );
    }

    public function smsBalance(): ?float
    {
        return $this->smsBalance;
    }

    public function viberBalance(): ?float
    {
        return $this->viberBalance;
    }
}
