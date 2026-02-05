<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

enum ViberMessageType: int
{
    case Service = 0;
    case Advertising = 1;
}
