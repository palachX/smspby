<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Api;

use Vetheslav\SmspBy\Http\RequestSender;
use Vetheslav\SmspBy\Response\SmsBulkCostResponse;
use Vetheslav\SmspBy\Response\SmsBulkSendResponse;
use Vetheslav\SmspBy\Response\SmsCostResponse;
use Vetheslav\SmspBy\Response\SmsSendResponse;
use Vetheslav\SmspBy\Response\StatusBulkResponse;
use Vetheslav\SmspBy\Response\StatusResponse;
use Vetheslav\SmspBy\ValueObject\SmsCostMessage;
use Vetheslav\SmspBy\ValueObject\SmsMessage;

final class SmsApi
{
    public function __construct(private readonly RequestSender $sender)
    {
    }

    public function send(SmsMessage $message): SmsSendResponse
    {
        $data = $this->sender->post('send/sms', $message->toSendArray());

        return SmsSendResponse::fromArray($data);
    }

    /**
     * @param SmsMessage[] $messages
     */
    public function sendBulk(array $messages): SmsBulkSendResponse
    {
        $payload = [];
        foreach ($messages as $message) {
            if (!$message instanceof SmsMessage) {
                throw new \InvalidArgumentException('Each message must be an instance of SmsMessage.');
            }
            $payload[] = $message->toBulkArray();
        }

        $data = $this->sender->post('sendBulk/sms', [
            'messages' => ApiHelpers::encodeMessages($payload),
        ]);

        return SmsBulkSendResponse::fromArray($data);
    }

    public function cost(SmsCostMessage $message): SmsCostResponse
    {
        $data = $this->sender->post('cost/sms', $message->toArray());

        return SmsCostResponse::fromArray($data);
    }

    /**
     * @param SmsCostMessage[] $messages
     */
    public function costBulk(array $messages): SmsBulkCostResponse
    {
        $payload = [];
        foreach ($messages as $message) {
            if (!$message instanceof SmsCostMessage) {
                throw new \InvalidArgumentException('Each message must be an instance of SmsCostMessage.');
            }
            $payload[] = $message->toArray();
        }

        $data = $this->sender->post('costBulk/sms', [
            'messages' => ApiHelpers::encodeMessages($payload),
        ]);

        return SmsBulkCostResponse::fromArray($data);
    }

    public function statusById(int|string $messageId): StatusResponse
    {
        $data = $this->sender->post('status/sms', [
            'message_id' => (string) $messageId,
        ]);

        return StatusResponse::fromSmsArray($data);
    }

    /**
     * @param array<int, int|string> $messageIds
     */
    public function statusBulkById(array $messageIds): StatusBulkResponse
    {
        $data = $this->sender->post('statusBulk/sms', [
            'message_ids' => ApiHelpers::joinIds($messageIds),
        ]);

        return StatusBulkResponse::fromSmsArray($data);
    }

    public function statusByCustomId(string $customId): StatusResponse
    {
        $this->assertCustomId($customId);

        $data = $this->sender->post('statusCustom/sms', [
            'custom_id' => $customId,
        ]);

        return StatusResponse::fromSmsArray($data);
    }

    /**
     * @param string[] $customIds
     */
    public function statusBulkByCustomId(array $customIds): StatusBulkResponse
    {
        foreach ($customIds as $customId) {
            $this->assertCustomId((string) $customId);
        }

        $data = $this->sender->post('statusCustomBulk/sms', [
            'message_ids' => ApiHelpers::joinIds($customIds),
        ]);

        return StatusBulkResponse::fromSmsArray($data);
    }

    private function assertCustomId(string $customId): void
    {
        if ($customId === '') {
            throw new \InvalidArgumentException('custom_id must be a non-empty string.');
        }
        if (mb_strlen($customId) > 20) {
            throw new \InvalidArgumentException('custom_id must be 20 characters or less.');
        }
    }
}
