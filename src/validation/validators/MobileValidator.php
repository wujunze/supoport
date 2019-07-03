<?php

namespace winwin\support\validation\validators;

class MobileValidator
{
    public function __invoke($field, $value, array $params, array $fields)
    {
        $pattern = "/^1[34578]\d{9}$/";

        return preg_match($pattern, $value);
    }
}
