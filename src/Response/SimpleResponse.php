<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Response;

use Vetheslav\SmspBy\Model\ApiError;

final class SimpleResponse extends AbstractResponse
{
    public static function fromArray(array $data): self
    {
        $success = ($data['status'] ?? true) !== false;
        $error = $success ? null : ApiError::fromMixed($data['error'] ?? null);

        return new self($success, $error, $data);
    }
}
