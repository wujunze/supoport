<?php

namespace winwin\support\validation\validators;

class IdCardValidator
{
    public function __invoke($field, $value, array $params, array $fields)
    {
        if (!is_string($value)) {
            return false;
        }
        if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $value)) {
            return false;
        }

        $provinces = [
            '11', '12', '13', '14', '15', '21', '22',
            '23', '31', '32', '33', '34', '35', '36',
            '37', '41', '42', '43', '44', '45', '46',
            '50', '51', '52', '53', '54', '61', '62',
            '63', '64', '65', '71', '81', '82', '91',
        ];

        if (!in_array(substr($value, 0, 2), $provinces)) {
            return false;
        }

        $value = preg_replace('/[xX]$/i', 'a', $value);
        $len = strlen($value);

        if ($len == 18) {
            $birthday = substr($value, 6, 4).'-'.substr($value, 10, 2).'-'.substr($value, 12, 2);
        } else {
            $birthday = '19'.substr($value, 6, 2).'-'.substr($value, 8, 2).'-'.substr($value, 10, 2);
        }

        if (date('Y-m-d', strtotime($birthday)) != $birthday) {
            return false;
        }

        if ($len == 18) {
            $sum = 0;

            for ($i = 17; $i >= 0; --$i) {
                $substr = substr($value, 17 - $i, 1);
                $sum += (pow(2, $i) % 11) * (($substr == 'a') ? 10 : intval($substr, 11));
            }

            if ($sum % 11 != 1) {
                return false;
            }
        }

        return true;
    }
}
