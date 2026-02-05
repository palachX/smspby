<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Response;

use Vetheslav\SmspBy\Model\ApiError;

final class TemplateCreateResponse extends AbstractResponse
{
    public function __construct(
        bool $success,
        ?ApiError $error,
        array $raw,
        private readonly ?int $templateId,
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
            isset($data['template_id']) ? (int) $data['template_id'] : null,
        );
    }

    public function templateId(): ?int
    {
        return $this->templateId;
    }
}
