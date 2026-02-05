<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

enum MessageChannel: string
{
    case Sms = 'sms';
    case Viber = 'viber';
}
