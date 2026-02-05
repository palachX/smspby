<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Model;

final class ApiError
{
    public function __construct(
        private readonly ?int $code,
        private readonly string $description,
        private readonly array $raw,
    ) {
        if ($this->description === '') {
            throw new \InvalidArgumentException('Error description must be a non-empty string.');
        }
    }

    public static function fromMixed(mixed $error): ?self
    {
        if ($error === null) {
            return null;
        }

        if (\is_string($error) && $error !== '') {
            return new self(null, $error, ['description' => $error]);
        }

        if (\is_array($error)) {
            $description = $error['description'] ?? '';
            if (!\is_string($description) || $description === '') {
                $description = json_encode($error, JSON_UNESCAPED_UNICODE) ?: 'Unknown error';
            }

            $code = null;
            if (isset($error['code']) && $error['code'] !== false) {
                $code = (int) $error['code'];
            }

            return new self($code, $description, $error);
        }

        return new self(null, (string) $error, ['description' => (string) $error]);
    }

    public function code(): ?int
    {
        return $this->code;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function raw(): array
    {
        return $this->raw;
    }
}
