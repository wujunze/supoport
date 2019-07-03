<?php

namespace winwin\support\exception;

class ValidationException extends \InvalidArgumentException implements Exception
{
    /**
     * @var array
     */
    private $errors;

    public function __construct(array $errors)
    {
        $this->errors = array_map(function ($messages) {
            return array_map(function ($message) {
                return preg_replace('/ /', '', $message, 1);
            }, $messages);
        }, $errors);
        parent::__construct(implode('，', call_user_func_array('array_merge', $this->errors)));
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
