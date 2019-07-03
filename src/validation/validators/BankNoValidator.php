<?php

namespace winwin\support\validation\validators;

class BankNoValidator
{
    public function __invoke($field, $value, array $params, array $fields)
    {
        return self::luhnCheck($value);
    }

    protected static function luhnCheck($number)
    {
        $checksum = 0;
        for ($i = (2 - (strlen($number) % 2)); $i <= strlen($number); $i += 2) {
            $checksum += (int) ($number[$i - 1]);
        }
        // Analyze odd digits in even length strings or even digits in odd length strings.
        for ($i = (strlen($number) % 2) + 1; $i < strlen($number); $i += 2) {
            $digit = (int) ($number[$i - 1]) * 2;
            if ($digit < 10) {
                $checksum += $digit;
            } else {
                $checksum += ($digit - 9);
            }
        }
        if (($checksum % 10) == 0) {
            return true;
        } else {
            return false;
        }
    }
}
