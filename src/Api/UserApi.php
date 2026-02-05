<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Api;

use Vetheslav\SmspBy\Http\RequestSender;
use Vetheslav\SmspBy\Response\BalanceResponse;
use Vetheslav\SmspBy\Response\SenderNamesResponse;

final class UserApi
{
    public function __construct(private readonly RequestSender $sender)
    {
    }

    public function balances(): BalanceResponse
    {
        $data = $this->sender->get('balances', []);

        return BalanceResponse::fromArray($data);
    }

    public function senderNames(): SenderNamesResponse
    {
        $data = $this->sender->get('senderNames', []);

        return SenderNamesResponse::fromArray($data);
    }
}
