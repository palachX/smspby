<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Vetheslav\SmspBy\Config\Credentials;
use Vetheslav\SmspBy\SmspByClient;
use Vetheslav\SmspBy\ValueObject\SmsCostMessage;
use Vetheslav\SmspBy\ValueObject\SmsMessage;
use Vetheslav\SmspBy\ValueObject\ViberMessage;

final class SmspByClientTest extends TestCase
{
    public function testSendSmsBuildsFormPayload(): void
    {
        $captured = [];
        $mock = new MockHttpClient(function (string $method, string $url, array $options) use (&$captured): MockResponse {
            $captured = compact('method', 'url', 'options');

            return new MockResponse(json_encode([
                'status' => true,
                'message_id' => 123,
                'price' => 0.1,
                'parts' => 1,
                'amount' => 0.1,
            ], JSON_UNESCAPED_UNICODE));
        });

        $client = new SmspByClient($mock, new Credentials('user', 'key'));

        $response = $client->sms()->send(new SmsMessage(
            msisdn: '375291234567',
            text: 'Test',
            sender: 'MySender',
        ));

        $this->assertTrue($response->isSuccess());
        $this->assertSame('POST', $captured['method']);
        $this->assertSame('https://cabinet.smsp.by/api/send/sms', $captured['url']);

        parse_str($captured['options']['body'], $payload);
        $this->assertSame('user', $payload['user']);
        $this->assertSame('key', $payload['apikey']);
        $this->assertSame('375291234567', $payload['msisdn']);
        $this->assertSame('Test', $payload['text']);
        $this->assertSame('MySender', $payload['sender']);
    }

    public function testBulkSmsCostEncodesMessages(): void
    {
        $captured = [];
        $mock = new MockHttpClient(function (string $method, string $url, array $options) use (&$captured): MockResponse {
            $captured = compact('method', 'url', 'options');

            return new MockResponse(json_encode([
                'status' => true,
                'messages' => [
                    ['msisdn' => '1', 'price' => 0.1, 'parts' => 1, 'amount' => 0.1],
                    ['msisdn' => '2', 'price' => 0.2, 'parts' => 1, 'amount' => 0.2],
                ],
            ], JSON_UNESCAPED_UNICODE));
        });

        $client = new SmspByClient($mock, new Credentials('user', 'key'));
        $client->sms()->costBulk([
            new SmsCostMessage('1', 'text 1'),
            new SmsCostMessage('2', 'text 2'),
        ]);

        $this->assertSame('POST', $captured['method']);
        $this->assertSame('https://cabinet.smsp.by/api/costBulk/sms', $captured['url']);

        parse_str($captured['options']['body'], $payload);
        $this->assertSame('user', $payload['user']);
        $this->assertSame('key', $payload['apikey']);
        $this->assertArrayHasKey('messages', $payload);
        $decoded = json_decode($payload['messages'], true);
        $this->assertSame('1', $decoded[0]['msisdn']);
        $this->assertSame('text 1', $decoded[0]['text']);
    }

    public function testViberMessagePrefersCallbackOverUrl(): void
    {
        $captured = [];
        $mock = new MockHttpClient(function (string $method, string $url, array $options) use (&$captured): MockResponse {
            $captured = compact('method', 'url', 'options');

            return new MockResponse(json_encode([
                'status' => true,
                'message_id' => 77,
                'price' => 0.2,
            ], JSON_UNESCAPED_UNICODE));
        });

        $client = new SmspByClient($mock, new Credentials('user', 'key'));
        $client->viber()->send(new ViberMessage(
            msisdn: '375291234567',
            text: 'Hello',
            buttonUrl: 'https://example.com',
            buttonCallbackNumber: '375291111111',
        ));

        parse_str($captured['options']['body'], $payload);
        $this->assertArrayHasKey('button_callback_number', $payload);
        $this->assertSame('375291111111', $payload['button_callback_number']);
        $this->assertArrayNotHasKey('button_url', $payload);
    }
}
