<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Response;

use Vetheslav\SmspBy\Model\ApiError;
use Vetheslav\SmspBy\ValueObject\Template;

final class TemplateListResponse extends AbstractResponse
{
    /**
     * @param Template[] $templates
     */
    public function __construct(
        bool $success,
        ?ApiError $error,
        array $raw,
        private readonly array $templates,
    ) {
        parent::__construct($success, $error, $raw);
    }

    public static function fromArray(array $data): self
    {
        $success = ($data['status'] ?? true) !== false;
        $error = $success ? null : ApiError::fromMixed($data['error'] ?? null);

        $rawTemplates = $data['teamplates'] ?? $data['templates'] ?? [];
        $templates = [];
        foreach ($rawTemplates as $template) {
            if (!\is_array($template) || !isset($template['template_id'], $template['name'], $template['text'])) {
                continue;
            }
            $templates[] = new Template(
                (int) $template['template_id'],
                (string) $template['name'],
                (string) $template['text'],
            );
        }

        return new self($success, $error, $data, $templates);
    }

    /**
     * @return Template[]
     */
    public function templates(): array
    {
        return $this->templates;
    }
}
