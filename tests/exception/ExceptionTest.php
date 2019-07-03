<?php

namespace winwin\support\exception;

use winwin\support\TestCase;

class ExceptionTest extends TestCase
{
    /**
     * @dataProvider exceptionNames
     */
    public function testException($exceptionClass)
    {
        $e = new $exceptionClass();
    }

    public function testValidationException()
    {
        $e = new ValidationException(['name' => ['Name 不能为空']]);
        $this->assertEquals($e->getMessage(), 'Name不能为空');
    }

    public function exceptionNames()
    {
        return [
            [DataIntegrityViolationException::class],
            [IOException::class],
            [NotFoundException::class],
        ];
    }
}
