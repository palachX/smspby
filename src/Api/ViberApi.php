<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Api;

use Vetheslav\SmspBy\Http\RequestSender;
use Vetheslav\SmspBy\Response\StatusBulkResponse;
use Vetheslav\SmspBy\Response\StatusResponse;
use Vetheslav\SmspBy\Response\ViberBulkCostResponse;
use Vetheslav\SmspBy\Response\ViberBulkSendResponse;
use Vetheslav\SmspBy\Response\ViberCostResponse;
use Vetheslav\SmspBy\Response\ViberSendResponse;
use Vetheslav\SmspBy\ValueObject\ViberCostMessage;
use Vetheslav\SmspBy\ValueObject\ViberMessage;

final class ViberApi
{
    /**
     * Creates a Viber API wrapper using the shared request sender.
     */
    public function __construct(private readonly RequestSender $sender)
    {
    }

    /**
     * Sends a single Viber message and returns the delivery metadata.
     */
    public function send(ViberMessage $message): ViberSendResponse
    {
        $data = $this->sender->post('send/viber', $message->toArray());

        return ViberSendResponse::fromArray($data);
    }

    /**
     * Sends up to 500 Viber messages in one request.
     * @param ViberMessage[] $messages
     */
    public function sendBulk(array $messages): ViberBulkSendResponse
    {
        $payload = [];
        foreach ($messages as $message) {
            if (!$message instanceof ViberMessage) {
                throw new \InvalidArgumentException('Each message must be an instance of ViberMessage.');
            }
            $payload[] = $message->toArray();
        }

        $data = $this->sender->post('sendBulk/viber', [
            'messages' => ApiHelpers::encodeMessages($payload),
        ]);

        return ViberBulkSendResponse::fromArray($data);
    }

    /**
     * Calculates the cost of a single Viber message without sending it.
     */
    public function cost(ViberCostMessage $message): ViberCostResponse
    {
        $data = $this->sender->post('cost/viber', $message->toArray());

        return ViberCostResponse::fromArray($data);
    }

    /**
     * Calculates costs for up to 500 Viber messages without sending them.
     * @param ViberCostMessage[] $messages
     */
    public function costBulk(array $messages): ViberBulkCostResponse
    {
        $payload = [];
        foreach ($messages as $message) {
            if (!$message instanceof ViberCostMessage) {
                throw new \InvalidArgumentException('Each message must be an instance of ViberCostMessage.');
            }
            $payload[] = $message->toArray();
        }

        $data = $this->sender->post('costBulk/viber', [
            'messages' => ApiHelpers::encodeMessages($payload),
        ]);

        return ViberBulkCostResponse::fromArray($data);
    }

    /**
     * Retrieves Viber delivery status by platform message ID.
     */
    public function statusById(int|string $messageId): StatusResponse
    {
        $data = $this->sender->post('status/viber', [
            'message_id' => (string) $messageId,
        ]);

        return StatusResponse::fromViberArray($data);
    }

    /**
     * Retrieves Viber delivery statuses for up to 500 platform message IDs.
     * @param array<int, int|string> $messageIds
     */
    public function statusBulkById(array $messageIds): StatusBulkResponse
    {
        $data = $this->sender->post('statusBulk/viber', [
            'message_ids' => ApiHelpers::joinIds($messageIds),
        ]);

        return StatusBulkResponse::fromViberArray($data);
    }

    /**
     * Retrieves Viber delivery status by custom_id.
     */
    public function statusByCustomId(string $customId): StatusResponse
    {
        $this->assertCustomId($customId);

        $data = $this->sender->post('statusCustom/viber', [
            'custom_id' => $customId,
        ]);

        return StatusResponse::fromViberArray($data);
    }

    /**
     * Retrieves Viber delivery statuses for up to 500 custom_id values.
     * @param string[] $customIds
     */
    public function statusBulkByCustomId(array $customIds): StatusBulkResponse
    {
        foreach ($customIds as $customId) {
            $this->assertCustomId((string) $customId);
        }

        $data = $this->sender->post('statusCustomBulk/viber', [
            'message_ids' => ApiHelpers::joinIds($customIds),
        ]);

        return StatusBulkResponse::fromViberArray($data);
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
