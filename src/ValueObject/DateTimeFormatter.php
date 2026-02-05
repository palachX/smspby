<?php

declare(strict_types=1);

namespace Vetheslav\SmspBy\ValueObject;

final class DateTimeFormatter
{
    /**
     * Formats a DateTime value to the API-required "Y-m-d H:i:00" format.
     */
    public static function formatForApi(\DateTimeInterface $dateTime): string
    {
        return $dateTime->format('Y-m-d H:i:00');
    }
}
