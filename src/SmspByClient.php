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

    public function sms(): SmsApi
    {
        return $this->smsApi;
    }

    public function viber(): ViberApi
    {
        return $this->viberApi;
    }

    public function user(): UserApi
    {
        return $this->userApi;
    }

    public function templates(): TemplateApi
    {
        return $this->templateApi;
    }
}
