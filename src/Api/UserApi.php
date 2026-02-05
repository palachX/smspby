<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\Api;

use Vetheslav\SmspBy\Http\RequestSender;
use Vetheslav\SmspBy\Response\BalanceResponse;
use Vetheslav\SmspBy\Response\SenderNamesResponse;

final class UserApi
{
    /**
     * Creates a user API wrapper using the shared request sender.
     */
    public function __construct(private readonly RequestSender $sender)
    {
    }

    /**
     * Fetches SMS and Viber balances for the authenticated account.
     */
    public function balances(): BalanceResponse
    {
        $data = $this->sender->get('balances', []);

        return BalanceResponse::fromArray($data);
    }

    /**
     * Fetches approved sender names for SMS and Viber channels.
     */
    public function senderNames(): SenderNamesResponse
    {
        $data = $this->sender->get('senderNames', []);

        return SenderNamesResponse::fromArray($data);
    }
}
