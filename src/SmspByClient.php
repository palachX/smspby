<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Vetheslav\SmspBy\Api\SmsApi;
use Vetheslav\SmspBy\Api\TemplateApi;
use Vetheslav\SmspBy\Api\UserApi;
use Vetheslav\SmspBy\Api\ViberApi;
use Vetheslav\SmspBy\Config\Credentials;
use Vetheslav\SmspBy\Http\RequestSender;

final class SmspByClient
{
    private readonly RequestSender $sender;
    private readonly SmsApi $smsApi;
    private readonly ViberApi $viberApi;
    private readonly UserApi $userApi;
    private readonly TemplateApi $templateApi;

    /**
     * Creates a new client instance configured with credentials and HTTP transport.
     */
    public function __construct(
        HttpClientInterface $httpClient,
        Credentials $credentials,
        ?LoggerInterface $logger = null,
        string $baseUri = 'https://cabinet.smsp.by/api/',
    ) {
        $this->sender = new RequestSender($httpClient, $credentials, $baseUri, $logger);
        $this->smsApi = new SmsApi($this->sender);
        $this->viberApi = new ViberApi($this->sender);
        $this->userApi = new UserApi($this->sender);
        $this->templateApi = new TemplateApi($this->sender);
    }

    /**
     * Creates a client with the default Symfony HTTP client implementation.
     */
    public static function createDefault(
        Credentials $credentials,
        ?LoggerInterface $logger = null,
        string $baseUri = 'https://cabinet.smsp.by/api/',
    ): self {
        $httpClient = \Symfony\Component\HttpClient\HttpClient::create();

        return new self($httpClient, $credentials, $logger, $baseUri);
    }

    /**
     * Returns the SMS API accessor for this client instance.
     */
    public function sms(): SmsApi
    {
        return $this->smsApi;
    }

    /**
     * Returns the Viber API accessor for this client instance.
     */
    public function viber(): ViberApi
    {
        return $this->viberApi;
    }

    /**
     * Returns the user API accessor for account-level operations.
     */
    public function user(): UserApi
    {
        return $this->userApi;
    }

    /**
     * Returns the templates API accessor for SMS/Viber templates.
     */
    public function templates(): TemplateApi
    {
        return $this->templateApi;
    }
}
