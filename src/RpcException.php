<?php

namespace winwin\support;

use kuiper\helper\Enum;
use kuiper\helper\Text;

abstract class RpcException extends \RuntimeException implements \Serializable
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var string ErrorCode class name
     */
    protected static $ERRORS;

    public function __construct($code, $message = null, $data = null)
    {
        $this->data = $data;
        if (!$code instanceof Enum) {
            $code = call_user_func([static::$ERRORS, 'fromValue'], $code);
        }
        parent::__construct($message ?: $code->description, $code->value);
    }

    public function getData()
    {
        return $this->data;
    }

    public function serialize()
    {
        return serialize([$this->data, $this->message, $this->code, $this->file, $this->line]);
    }

    public function unserialize($data)
    {
        list($this->data, $this->message, $this->code, $this->file, $this->line)
            = unserialize($data);
    }

    public static function __callStatic($name, $args)
    {
        $code = call_user_func([static::$ERRORS, 'fromName'], strtoupper(Text::uncamelize($name)));
        $exceptionClass = get_called_class();
        $pos = strrpos($exceptionClass, '\\');
        $subExceptionClass = substr($exceptionClass, 0, $pos + 1).ucfirst($name).'Exception';
        if (class_exists($subExceptionClass)) {
            $exceptionClass = $subExceptionClass;
        }
        $exception = new $exceptionClass($code, isset($args[0]) ? $args[0] : null, isset($args[1]) ? $args[1] : null);
        // 设置 file, line 为实际调用位置
        $stack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
        if (isset($stack[0]['file'])) {
            $exception->file = $stack[0]['file'];
            $exception->line = $stack[0]['line'];
        }

        return $exception;
    }
}
