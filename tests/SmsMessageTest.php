<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Tests;

use PHPUnit\Framework\TestCase;
use Vetheslav\SmspBy\ValueObject\SmsMessage;

final class SmsMessageTest extends TestCase
{
    public function testBulkRejectsShortlinks(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $message = new SmsMessage(
            msisdn: '375291234567',
            text: 'Hello',
            useShortLinks: true,
        );

        $message->toBulkArray();
    }

    public function testRejectsLongSmsSender(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new SmsMessage(
            msisdn: '375291234567',
            text: 'Hello',
            sender: str_repeat('A', 12),
        );
    }

    public function testRejectsLongCustomId(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new SmsMessage(
            msisdn: '375291234567',
            text: 'Hello',
            customId: str_repeat('B', 21),
        );
    }
}
