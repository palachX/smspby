<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Tests;

use PHPUnit\Framework\TestCase;
use Vetheslav\SmspBy\Response\StatusResponse;
use Vetheslav\SmspBy\ValueObject\SmsMessageStatus;
use Vetheslav\SmspBy\ValueObject\ViberMessageStatus;

final class MessageStatusTest extends TestCase
{
    public function testSmsStatusUsesEnum(): void
    {
        $response = StatusResponse::fromSmsArray([
            'status' => true,
            'message_status' => [
                'code' => 3,
                'name' => 'Delivered',
            ],
        ]);

        $status = $response->messageStatus();
        $this->assertSame(SmsMessageStatus::Delivered, $status->code());
    }

    public function testViberStatusUsesEnum(): void
    {
        $response = StatusResponse::fromViberArray([
            'status' => true,
            'message_status' => [
                'code' => 5,
                'name' => 'Read',
            ],
        ]);

        $status = $response->messageStatus();
        $this->assertSame(ViberMessageStatus::Read, $status->code());
    }

    public function testStatusNotFoundIsPreserved(): void
    {
        $response = StatusResponse::fromSmsArray([
            'status' => true,
            'message_status' => [
                'code' => false,
                'name' => 'Not found',
            ],
        ]);

        $status = $response->messageStatus();
        $this->assertNull($status->code());
        $this->assertTrue($status->isNotFound());
        $this->assertSame(false, $status->gatewayStatus()->rawCode());
    }
}
