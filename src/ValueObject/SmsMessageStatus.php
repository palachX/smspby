<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

enum SmsMessageStatus: int
{
    case New = 0; // Новое.
    case Sent = 1; // Отправлено.
    case Blocked = 2; // Заблокировано.
    case Delivered = 3; // Доставлено.
    case NotDelivered = 4; // Не доставлено.
    case Delivering = 5; // Доставляется.
}
