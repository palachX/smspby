<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

final class DateTimeFormatter
{
    public static function formatForApi(\DateTimeInterface $dateTime): string
    {
        return $dateTime->format('Y-m-d H:i:00');
    }
}
