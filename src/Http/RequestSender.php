<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Http;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Vetheslav\SmspBy\Config\Credentials;
use Vetheslav\SmspBy\Exception\InvalidResponseException;
use Vetheslav\SmspBy\Exception\TransportException;

final class RequestSender
{
    private readonly LoggerInterface $logger;

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly Credentials $credentials,
        private readonly string $baseUri,
        ?LoggerInterface $logger = null,
    ) {
        $this->logger = $logger ?? new NullLogger();
    }

    /**
     * @return array<string, mixed>
     */
    public function post(string $path, array $params): array
    {
        return $this->request('POST', $path, $params, false);
    }

    /**
     * @return array<string, mixed>
     */
    public function get(string $path, array $params): array
    {
        return $this->request('GET', $path, $params, true);
    }

    /**
     * @return array<string, mixed>
     */
    private function request(string $method, string $path, array $params, bool $useQuery): array
    {
        $payload = array_merge($params, [
            'user' => $this->credentials->user(),
            'apikey' => $this->credentials->apiKey(),
        ]);

        $options = [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ];

        if ($useQuery) {
            $options['query'] = $payload;
        } else {
            $options['body'] = http_build_query($payload);
        }

        try {
            $response = $this->httpClient->request($method, $this->buildUrl($path), $options);
        } catch (TransportExceptionInterface $exception) {
            $this->logger->error('SMSp.by transport error', ['exception' => $exception]);
            throw new TransportException('Transport error while calling SMSp.by API.', 0, $exception);
        }

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            $this->logger->error('SMSp.by HTTP error', ['status' => $statusCode, 'path' => $path]);
            throw new TransportException('Unexpected HTTP status: '.$statusCode, $statusCode);
        }

        $content = $response->getContent(false);
        $decoded = json_decode($content, true);
        if (!\is_array($decoded)) {
            $this->logger->error('SMSp.by invalid JSON response', ['path' => $path, 'body' => $content]);
            throw new InvalidResponseException('Invalid JSON response from SMSp.by API.');
        }

        return $decoded;
    }

    private function buildUrl(string $path): string
    {
        return rtrim($this->baseUri, '/').'/'.ltrim($path, '/');
    }
}
