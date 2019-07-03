<?php

namespace winwin\support\validation;

use Valitron\Validator;

class ValidatorFactory
{
    public function __construct(array $validators = [], $langDir = null)
    {
        Validator::lang('zh-cn');
        if ($langDir) {
            Validator::langDir($langDir);
        } else {
            Validator::langDir(__DIR__.'/lang');
        }
        foreach ($validators as $name => $validator) {
            Validator::addRule($name, $validator, '不正确');
        }
    }

    public function create(array $data = [])
    {
        return new Validator($data);
    }
}
