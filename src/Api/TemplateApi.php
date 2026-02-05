<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Api;

use Vetheslav\SmspBy\Http\RequestSender;
use Vetheslav\SmspBy\Response\SimpleResponse;
use Vetheslav\SmspBy\Response\TemplateCreateResponse;
use Vetheslav\SmspBy\Response\TemplateListResponse;

final class TemplateApi
{
    public function __construct(private readonly RequestSender $sender)
    {
    }

    public function createSms(string $name, string $text): TemplateCreateResponse
    {
        $this->assertNonEmpty($name, 'name');
        $this->assertNonEmpty($text, 'text');

        $data = $this->sender->post('templateCreate/sms', [
            'name' => $name,
            'text' => $text,
        ]);

        return TemplateCreateResponse::fromArray($data);
    }

    public function updateSms(int $templateId, ?string $name = null, ?string $text = null): SimpleResponse
    {
        $this->assertUpdateFields($name, $text);

        $payload = ['template_id' => $templateId];
        if ($name !== null) {
            $payload['name'] = $name;
        }
        if ($text !== null) {
            $payload['text'] = $text;
        }

        $data = $this->sender->post('templateUpdate/sms', $payload);

        return SimpleResponse::fromArray($data);
    }

    public function deleteSms(int $templateId): SimpleResponse
    {
        $data = $this->sender->post('templateDelete/sms', [
            'template_id' => $templateId,
        ]);

        return SimpleResponse::fromArray($data);
    }

    public function listSms(): TemplateListResponse
    {
        $data = $this->sender->post('templateList/sms', []);

        return TemplateListResponse::fromArray($data);
    }

    public function createViber(string $name, string $text): TemplateCreateResponse
    {
        $this->assertNonEmpty($name, 'name');
        $this->assertNonEmpty($text, 'text');

        $data = $this->sender->post('templateCreate/viber', [
            'name' => $name,
            'text' => $text,
        ]);

        return TemplateCreateResponse::fromArray($data);
    }

    public function updateViber(int $templateId, ?string $name = null, ?string $text = null): SimpleResponse
    {
        $this->assertUpdateFields($name, $text);

        $payload = ['template_id' => $templateId];
        if ($name !== null) {
            $payload['name'] = $name;
        }
        if ($text !== null) {
            $payload['text'] = $text;
        }

        $data = $this->sender->post('templateUpdate/viber', $payload);

        return SimpleResponse::fromArray($data);
    }

    public function deleteViber(int $templateId): SimpleResponse
    {
        $data = $this->sender->post('templateDelete/viber', [
            'template_id' => $templateId,
        ]);

        return SimpleResponse::fromArray($data);
    }

    public function listViber(): TemplateListResponse
    {
        $data = $this->sender->post('templateList/viber', []);

        return TemplateListResponse::fromArray($data);
    }

    private function assertUpdateFields(?string $name, ?string $text): void
    {
        if ($name === null && $text === null) {
            throw new \InvalidArgumentException('Either name or text must be provided.');
        }
    }

    private function assertNonEmpty(string $value, string $field): void
    {
        if ($value === '') {
            throw new \InvalidArgumentException($field.' must be a non-empty string.');
        }
    }
}
