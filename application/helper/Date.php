<?php

namespace Application\Helper;

class Date
{
    public static function validateFormat($date, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);

        return $d && $d->format($format) == $date;
    }
}