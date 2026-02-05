<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

enum ViberMessageStatus: int
{
    case New = 0; // Новое.
    case Sent = 1; // Отправлено.
    case Blocked = 2; // Заблокировано.
    case NotDelivered = 3; // Не доставлено.
    case Delivered = 4; // Доставлено.
    case Read = 5; // Прочитано.
    case Expired = 7; // Просрочено.
    case Error = 8; // Ошибка.
}
